<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Template extends Controller_Template {

    /**
     * @var string Имя файла основного шаблона
     */
    public $template = 'layout/base';

    /**
     * @var array Данные основного шаблона
     */
    public $data = array();

    /**
     * @var array Контекст для content шаблона
     */
    public $context = array();

    /**
     * @var array Контекст для header шаблона
     */
    public $header = array();

    /**
     * @var array Контекст для footer шаблона
     */
    public $footer = array();

    /**
     * @var string Имя текущего модуля (контроллера)
     */
    public $module_name = NULL;

    /**
     * @var string Имя файла шаблона для $this->template->content
     */
    public $context_template = 'frontend/default';

    /**
     * @var string Префикс текущего шаблона
     */
    public $prefix_template = 'frontend/';

    /**
     * @var boolean
     */
    public $is_ajax = FALSE;

    /**
     * @var boolean
     */
    protected $_is_content = FALSE;

    protected $template_head = array();

    /**
     *
     * @var bool
     */
    protected $_no_data = FALSE;

    public $uri = NULL;

    public $only_subrequest = FALSE;

    public function __construct(Request $request, Response $response)
    {
        $this->template = $this->prefix_template.$this->template;

        $this->context_template = $request->controller().'/'.$request->action();

        if ($this->module_name == NULL)
        {
            $this->module_name = $request->controller();
        }

        if ($request->directory())
        {
            $this->context_template = $request->directory().'/'.$this->context_template;
        }

        parent::__construct($request, $response);
    }

    public function before()
    {
        if ( ! $this->request->is_initial())
        {
            $this->uri = '/'.$this->request->initial()->uri().'/';
        }
        else
        {
            $this->uri = '/'.$this->request->uri().'/';
        }

        if ($this->only_subrequest AND $this->request->is_initial())
        {
            throw new HTTP_Exception_404;
        }

        View::set_global('message', Message::render('frontend'));

        // parent'a не надо вызывать!
    }

    public function after()
    {
        // если нет шаблона и если нет вызова _content() то юзаем шаблон по умолчанию
        if (Kohana::find_file('views', $this->context_template) === FALSE && ! $this->_is_content)
        {
            $this->context_template = $this->prefix_template.'default';
        }

        if ($this->auto_render === TRUE)
        {
            $local_prefix_template = $this->prefix_template;

            if ( ! $this->only_subrequest || $this->request->is_initial())
            {
                if ( ! $this->_no_data)
                {
                    $this->data['content'] = (string) View::factory($this->context_template, $this->context);
                }
                else
                {
                    $this->data['content'] = (string) View::factory($local_prefix_template.'layout/nodata');
                }

                $this->data['header']  = (string) View::factory($local_prefix_template.'layout/header', $this->header);
                $this->data['footer']  = (string) View::factory($local_prefix_template.'layout/footer', $this->footer);

                $this->template = View::factory($this->template, $this->data);
            }
            else
            {
                if ( ! $this->_no_data)
                {
                    $this->template = View::factory($this->context_template, $this->context);
                }
                else
                {
                    $this->template = (string) View::factory($local_prefix_template.'/layout/nodata');
                }
            }
        }

        parent::after();
    }

    /**
     * Для HMVC (вызывать если у action'a нету view)
     * @param string $html
     */
    protected function _content($html)
    {
        $this->_is_content = TRUE;
        $this->context['content'] = $html;
        $this->context_template = 'frontend/content';
    }

    public function is_submit()
    {
        return Security::check($this->request->post('csrf_token'));
    }

    public function is_action_index()
    {
        return $this->request->action == 'index';
    }

    public function is_action_view()
    {
        return $this->request->action == 'view';
    }
}
