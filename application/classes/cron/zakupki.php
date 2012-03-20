<?php defined('SYSPATH') or die('No direct script access.');

class Cron_Zakupki implements Cron_Interface {

    public static function factory()
    {
        return new self;
    }

    public function run()
    {
        $zakupki = new Zakupki();
        $result = $zakupki->go("http://zakupki.gov.ru/pgz/public/action/search/extended/rss?c0=true&a=true&c=AP&c=CW&d=&_e=on&_f=on&_g=on&h=&j=true&_j=on&k=&l=&m=&n=&o=&i=01.03.2012&p=19.03.2013&q=&r=&s=&b8=true&t=&customer.organizationId=&v=5277335&_w=on&x=&y=&_z=on&a0=&sellerOrganizationId=&b7=false&f_MP=c&f_NU=c&f_OLIMPSTROI=c&b6=false&f_UG=c&f_IN=c&b9=false&a1=&a2=&a4=&a5=&a6=&a7=&b5=&a8=&_a9=on&lotView=false&b0=&b1=true&_b1=on&_b2=on&_b3=on&_b4=on&ext=f3fcee622c249601c48357b11ff5292c");

        echo "\n Добавлено новых : ".$result."\n";
    }
}
