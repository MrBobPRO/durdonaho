<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $body = [];
        array_push($body, 'Масъала дар бораи он ки тамаддунҳои рушдёфта дар дигар қисмҳои олам вуҷуд доранд, ҳамеша бо се масъалаи номаълум дар муодилаи Дрейк алоқаманд буданд. Мо медонем, ки тақрибан чанд ситора мавҷуд аст. Мо намедонем, ки чӣ қадар ин ситораҳо сайёраҳое доранд, ки ҳаётро дастгирӣ мекунанд, чанд вақт ҳаёт пайдо мешавад ва ба пайдоиши махлуқоти соҳибақл оварда мерасонад ва тамаддун чӣ қадар метавонад қабл аз он ки аз байн равад. Мо ҳатто намедонем, ки тамаддуни баландтехнологӣ метавонад барои якчанд асрҳо вуҷуд дошта бошад ё не.');
        
        array_push($body, 'Дар ин ҷаҳон ҳама чиз хеле оддӣ ба тартиб оварда шудааст, вагарна ҳеҷ кор нахоҳад шуд, мушкил дар он аст, ки ин содагӣ аз ҳад зиёд аст.');

        array_push($body, 'Тағйирот ногузиранд, бинобар ин Шумо бояд онҳоро бо хурсандӣ қабул кунед. Беҳтараш худатон ин иқдомро пайгирӣ намоед.');

        array_push($body, 'Тасодуф - ин танҳо як номи дигари ногузирист.');

        array_push($body, 'Нубуғи бани одамӣ ченаки доимист, мисли онест, ки миқдори газҳои нодир дар ҳаво доимист.');

        array_push($body, 'Дар тамоми роҳе, ки аз васат ва дуртар аз китфи рост мегузарад, зиндагӣ танҳо аз бактерияҳо иборат буд. Зиндагии бисёрҳуҷайраю бесутунмуҳра танҳо дар наздикии оринҷи рости Шумо сабзидааст. Динозаврҳо дар васати кафи рости Шумо ибтидо мегиранд ва дар ноҳияи қатори (раддаи) охирини ангушт мемиранд. Тамоми таърихи Homo Sapiens ва ниёи мо Homo Erectus дар нӯги нохун ҷой мегирад.');

        array_push($body, 'Беходоӣ ин воқеият аст. Вай бар он асос ёфтааст, ки он воқеият аст ва мо онро меомӯзем. Муайян кардани бехудоӣ чун инкори Худо нодуруст аст. Чаро онро инкор бикунӣ, агар дар ибтидо мавҷудияти онро исбот бикунӣ. Яъне ин бехудоӣ (атеизм) мавҷудияти Худоро инкор мекунад. Чунин атеизм онро исбот мекунад.');

        array_push($body, 'Таҳсилот ин бишнавонидани тамаддун аст.');

        array_push($body, 'Дониш андар дил чароги равшан аст. Ваз хама бад бар тани ту чавшан аст.');

        for($i=0; $i<count($body); $i++) {
            $q = new Quote();
            $q->body = $body[$i];
            $q->author_id = $i+1;
            $q->popular = true;
            $q->save();

            $q->categories()->attach(rand(1,15));
            $q->categories()->attach(rand(16,29));
        }
    }
}
