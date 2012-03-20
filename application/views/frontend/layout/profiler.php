<?php if(Kohana::$environment == Kohana::DEVELOPMENT):?>
<!-- Profiler -->
<script type="text/javascript">
$(document).ready(function(){

    $('#profiler-toggler').click(function(){
        $('#profiler-content').slideToggle();
    });
});
</script>
<div id="profiler-wrapper" style="float:left;padding:5px;">
    <span id="profiler-toggler" style="cursor:pointer;padding:15px;font-size:10px;color:gray">Profiler show/hide</span>
    <div id="profiler-content" style="display:none">
        <?=View::factory('profiler/stats')?>
    </div>
</div>
<!-- /Profiler -->
<?php endif;?>