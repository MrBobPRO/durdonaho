<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opt = new Option();
        $opt->key = 'privacy-policy';
        
        $opt->value = '<p>Ин Созишномаи корӣ (минбаъд “Созишнома”) шомили пешниҳод ба корбарони шабакаи Интернет (минбаъд  “Корбарон”) дар мавриди бастани созишнома оид баистифодабарии сервисҳоест/хадамотест (минбаъд “Хадамот/Сервисҳо”), ки дар сомонаи durdonaho.tj (минбаъ “Сомона”) мавҷуд мебошанд.</p>
        <p><b>1. Муқаррароти умумӣ</b></p>
        <p>1.1. Истифодаи Сомона ва Хадамот аз ҷониби Корбар тавассути Созишномаи мазкур ба танзим дароварда мешавад.</p>
        <p>1.2. Дар робита ба Созишномаи мазкур ва муносибати байни Сомона ва Корбар, ки ҳангоми истифодаи Сомона ва Хадамот ба вуҷуд меоянд, қонунгузории Ҷумҳурии Тоҷикистон истифода мешавад.</p>
        <p>1.3. Корбар дар Сомона сабт шуда ва ё аз имкони ҷой додани ҳама гуна иттилоъ, ҳар навъ маводи дорои хусусиёти гуногун дар Сомона (минбаъд Иттилоъ), боздиди иттилоот дар Сомона ва ё ҳар навъ имкониятҳои вазифавии Сомона ва Сервис истифода бурда, ӯ ризоияти бечунучарои хешро ба ҳама шартҳои Созишномаи мазкур изҳор дошта, риояи онро бар уҳда мегирад. Дар сурати адами мавҷудияти ризоияти Корбар ба ҳама шартҳои Созишномаи мазкур, ӯ уҳдадор аст, ки билотаъхир истифодаи Сомона ва Хадамотро қатъ кунад.</p>
        <p><b>2. Пешниҳод, ҷойгиркунӣ ва истифодаи иттилоъ</b></p>
        <p>2.1.Дастрасии комил ба Сомона ва Хадамот, азҷумла, сохтани рухнамои (профили) Корбар, ҷойгиркунии Иттилоъ танҳо ба Корбари сабтшуда имконпазир аст.</p>
        <p>2.2.Корбар мустақилона ба маҳфузияти сабти вуруд (логин) ва гузарвожа/исми рамзи (пароли)  худ посухгӯ буда, ҳаққи интиқол ва вогузор кардани онро ба ашхоси саввум надорад. Ҳама аъмоле, ки Корбар дар Сомона бо истифода аз сабти вуруд (логин)  ва исми рамзаш( паролаш) анҷом медиҳад, амали аз ҷониби Корбар ба иҷро расида шуморида мешавад.</p>
        <p>2.2.Корбар ҳангоми ҷойгир кардани Иттилоъ ва истифодаи дигари  Хадамот уҳдадор аст, ки шароит ва маҳдудияти зеринро риоя кунад:</p>
        <p>2.2.1.Иттилоъе (бо фарогирии ҳама гуна мавод),ки аз ҷониби Корбар ҷойгир карда мешавад, набояд ҳаққи муаллифӣ, ҳуқуқ банишонаҳои маҳсулот, воситаҳои фардикунонӣ ва (ва ё) ҳуқуқ ба дигар объектҳои моликияти зеҳниро, ки ба ашхосисаввум муталлиқанд, поймол  созад;</p>
        <p>2.2.2. Дар Сомона ва ҳангоми истифодабарии Хадамот содир кардани амалҳое, ки барои гумроҳ кардани дигар корбарон равона шудааанд, манъ аст;</p>
        <p>2.2.3. Дар чаҳорчӯбаи Сомона ҷойгир кардани (интишори) Иттилоъ ва шарҳу табсираҳое, ки ҳуқуқ ва манфиатҳои қонунии ашхоси саввумро (ҳамчунин маводе, ки  хусусиёти паёмҳои бозаргонӣ,  шаҳвонӣ, порнографӣ ва таҳқирӣ доранд) поймол мекунанд, манъ аст.</p>
        <p>2.2.4. Дар чаҳорчӯбаи Сомона манъ аст:</p>
        <ul>
        <li>Тарғиби хушунат, табъизи нажодӣ, ҷинсӣ, миллӣ, мазҳабӣ;</li>
        <li>Пешбурди фаъолияти тиҷорӣ дар ҳар шаклаш, азҷумла: реклом намудани маҳсулот ва хадамот, пойгоҳҳои (захираҳои)  интернетӣ ва дигар  маҳсулот, аз он ҷумла дар дигарномҳо (никҳо), чеҳракҳор (аватараҳо), имзоҳо.</li>
        <li>Ҳама гуна мукотиба ба дигар корбарон тавассути шарҳҳо ба хотири ба даст овардани суду манфиати тиҷорӣ манъ аст;</li>
        <li>Интишори дигар навъ иттилоъ, ки ба андешаи маъмури сомона, ба рисолат, арзишҳо, сиёсати мавзуъӣ ва ҳадафи пойгоҳ (портал) мувофиқат намекунад;</li>
        <li>Чеҳраки (Аватари) корбар иттилои ҷамъиятӣ буда, он набояд:</li>
        <li>Муносибати беэҳтиромона ба ҳамсуҳбат: руҷуъи дурушт ба шахсият (ишора кардан ба вазифаи машғулӣ, норасоиҳои ҷисмонӣ, ихтилоли равонӣ, арзёбии сифатии ҳамсуҳбат, тавсифи густохонаи аъмоли ӯ, муҳокимаи манфии сифатҳои шахсӣ ва шаклҳои дигар)</li>
        <li>Истифодаи як нафар Корбар беш аз як рухнома (профайл) дар Сомона, аз он ҷумла,  барои чапғалат задан аз масдудсозии муваққатии рухнома, раъйдиҳӣ ба иқтибосҳо, шарҳҳои хеш.</li>
        <li>Маъмурияти Сомона дар симои медараторҳо (гардонандаҳо) ҳақ дорад чунин навъ маводро ҳазф кунад, масдуд созад ва рухнамои  (профайли) муаллифони онҳоро ҳазф кунад.</li>
        <li>2.2.5. Аъмоли Корбар набояд ҳуқуқи шаҳрвандон, корбарони дигари Сомона, аз он ҷумла, ҳуқуқ ба дахлнопазирии ҳаёти шахсӣ, асрори  шахсӣ ва хонаводагӣ, шаъну шараф,  номи  некро  поймол созад.</li>
        <li>2.3. Корбар ба он мувофиқ, ки Иттилои дар Сомона интишор намудааш, барои дигар корбарон чӣ мустақиман дар Сомона ва ҳам тавассути бозшунавоӣ дар гуруҳҳои шабакаҳои иҷтимоӣ, ки ба Сомона марбутанд, бо ишора кардани муаллиф, дар он ҳаҷме, ки Корбар Иттилоъро  дар Сомона иштишор намудааст, дастрас мебошанд.</li>
        <li>2.4. Корбар мувофиқ бар он аст, он Иттилоъе (ҳама қисматҳои он), ки  дастрасӣ ба он масдуд нест, дастраси ҳамагонӣ шуморида мешавад ва риояи низоми  махфияти онро талаб намекунад.</li>
        </ul>
        <p>2.5. Корбар ба он мувофиқ аст, ки бо ҷойгир кардан ва интишори ҳар навъ Иттилоъ тавассути Сомона ва Хадамот, вай иҷозати онро медиҳад, то Сомона ва корбари Интернет (аз он ҷумла корбари сабти номнашудаи Сомона)  аз он тибқи Созишномаи мазкур ройгон ва бемаҳдуд  кор бигирад (агар чунин истифодабарӣ ба қонунгузории Ҷумҳурии Тоҷикистон мухолиф набошад)</p>
        <p>Дар ин маврид Корбар бояд мустақилона ҳама ҳатарҳо ва чолишҳои марбут ба истифодаи иттилоъи аз ҷониби корбарони дигар интишоршударо, бо дарназардошти арзёбии муътамаднокии онҳо, мукаммалӣ ва ё аҳамиятнокии онҳо арзёбӣ (баррасӣ)  кунад.</p>
        <p>2.6.Корбар ба он мувофиқ аст, ки  Маъмури Сомона ҳақ дорад ба ашхоси саввум, азҷумла, ноширон ва шабакаҳои рекломӣ иҷозат бидиҳад, то рекломи хешро дар Сомона ҷойгир кунанд.  Бинобар ин Корбар мувофиқ бар он аст, ки ҳар кадоме аз ин ашхоси саввум ҳақ доранд , то кулучак (кук-файл) ҳоро дар роёнаи Корбар ҷойгир кунад. Ҳадаф аз он  шиносоии роёнаи Корбар дар ҳар боре, ки  ин ширкатҳо ба Корбар онлайн-рекламро ирсол мекунанд. Дар ин маврид Корбар дармеёбад, ки Маъмури Сомона истифодаи кулучак(кук-файл)ҳои Корбарро ҳангоми ҷойгир кардани рекломҳ оаз ҷониби ашхоси саввум назорат намекунад. Корбар ҳақ дорад истифодаи иттилоъи шахсияшро аз ҷониби ашхоси саввум барои интишори реклама манъ созад. Чунин мамнуъият ба имконияти истифодаи мутолиаи хабарҳои рекломӣ дар Сомона таъсир намерасонад.</p>
        <p><b>3. Масъулият</b></p>
        <p>3.1. Корбар мустақилона дар назди ашхоси саввум барои аъмоли хеш ҳангоми истифодабарии Сомона ва Хадамот, аз он ҷумла барои он ки онҳо ба талаботи қонунгузорӣ мувофиқанд ва ҳуқуқ ва манфиатҳои қонунии ашхоси саввумро поймол намекунанд, масъулият дорад. Корбар мустақилона ва аз ҳисоби хеш уҳдадор аст, то  ҳама арзу шикоятҳои ашхоси саввумро, ки ба аъмоли Корбар ҳангоми истифодабарии Хадамот марбутанд, ба танзим дароварад.</p>
        <p>3.2.Сомона ҳуқуқ дорад, то бидуни огаҳӣ аз рӯйи хоҳиши хеш Иттилои аз тарафи Корбар интишоршударо қисман ё комилан  ҳазф кунад. Азҷумла, ӯ ҳақ дорад шарҳҳо ва ё дигар аъмоли дигарро, ки  ба талаботи Созишномаи имазкур  мувофиқ нестанд ва аз ҷониби Корбар дар Сомона интишор ёфтаанд, ҳазф ва бекор кунад.</p>
        <p>3.3.Барои риоя накардани муқаррароти Созишномаи мазкур ва дигар асноди истифодашаванда метавонад дастрасии Корбарро ба Сомона масдуд созад ва ё рухнамои (профили) Корбарро бидуни огоҳии қаблӣ  ҳазф кунад.</p>
        <p>3.4.Сомона барои истифодаи Иттилое, ки аз ҷониби Корбар дар Сомона нашр шуда, аз тарафи  ашхоси  саввум истифода шудаанд, бо шумули шунавонидан ва иштишор намудани он дар Сомона ва Хадамот, ҳамчунин бо роҳҳои имконпазири дигар,  бар дӯш масъулият надорад.</p>
        <p>3.5.Сомона тафтиш намекунад, тағйир намесозад ва ба дӯши худ  уҳдадориҳоро ҷиҳати назорат  болои муҳтавои иттилооте, ки дар чавкоти Сомонава Хадамот аз тарафи корбарон ҷой дода шудаанд, намегирад ва барои муътамадӣ, қонунӣ ва сифати он, ҳамчунин мувофиқати иттилоъ ба дархостҳои мушаххас ва талаботи корбарони Сервис масъулият надорад, кафолат намедиҳад.</p>
        <p>3.6.Сомона барои муҳтавое, ки ба он мутааллиқ нест, иқтибосҳое, ки дар таркиби Иттилоъ мавҷуд мебошанд, бар дӯш масъулият надорад ва барои дастрас будани онҳо, кори дурусти он, мутобиқати он ба мавзуъи матраҳшуда кафолат намедиҳад.</p>
        <p>3.7.Сомона ба зараре, ки  ба  таври мустақим ва ё номустақим ба Корбар бинобар истифода бурдан ва/ва ё мавҷуд набудани  имконияти истифодаи Сомона ва/ва ё Хадамот расонида шудаанд, ҷуброн нахоҳад кард.</p>
        <p><b>4. Шароити дигар</b></p>
        <p>4.1. Сервис аз ҷониби Сомона “ҳамон тавре, ки ҳаст”, пешниҳод мегардад. Сомона барои мувофиқати иттилоъ ва Хадамот барои ҳадафҳо ва интизориҳои Корбар, кори муттасил ва бехато , ҳамчунин маҳфузияти рухнамои (профили) Корбар, ки аз тарафи Корбар дар Сомонаи Иттилоъ ҷойгир шудаанд, кафолат намедиҳад.</p>
        <p>4.2.Ҳамаи арзу шикоятҳои марбут ба ғайри имкон будани истифодаи Сомона ва Хадамот бояд тавассути почтаи электронӣ ба суроғаи <a href="mailto:info@durdonaho.tj">info@durdonaho.tj</a> ирсол шаванд.</p>
        <p>4.3.Сомона ҳақ дорад дар ҳар вақт бидуни огаҳии Корбар матни Созишномаи мазкурро ва  / ва ё ҳама гуна шароити дигари истифодаи  Сомона ва Хадамотро тағйир диҳад.</p>
        <p>Дар ҳолатҳое, ки дар ин Созишнома дарҷ нашудаанд, маъмурият ҳуқуқ дорад аз рӯйи майлу хоҳиши худ амал кунад.</p>
        ';

        $opt->save();
    }
}
