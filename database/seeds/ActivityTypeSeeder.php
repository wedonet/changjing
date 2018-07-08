<?php

/* 填充活动类型 */

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityType as ActivityType;

class ActivityTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $v['ic'] = 'd';
        $v['title'] = '德';
        $v['readme'] = '坚定理想信念，追求高尚品德，勇于承担社会责任。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'ds';
        $v['title'] = '思想道德';
        $v['readme'] = '能正确认识中国发展大势，坚定中国特色社会主义道路自信、理论自信、制度自信、文化自信，树立中国特色社会主义共同理想，努力培育和践行社会主义核心价值观，具有较强德法制观念和诚信意识。';
        $v['mydepth'] = 1;
        $v['pic'] = 'd';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'dz';
        $v['title'] = '责任担当';
        $v['readme'] = '能正确认识时代责任和历史使命，具有责任意识、担当精神，有集体主义观念、组织纪律和奉献精神，主动参与学校、学院建设，主动为同学服务，有较强领导素质和领导艺术，善于组织和协调。';
        $v['mydepth'] = 1;
        $v['pic'] = 'd';
        $v['target'] = 1;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'y';
        $v['title'] = '业';
        $v['readme'] = '具有自主学习能力、独立生活能力和职业胜任力。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'yx';
        $v['title'] = '学业能力';
        $v['readme'] = '具备良好的学习习惯，掌握适合自身 的学习方法，培育自主学习能力，养成良好的阅读习惯，具备运用专业知识分析、解决问题的能力。';
        $v['mydepth'] = 1;
        $v['pic'] = 'y';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'yz';
        $v['title'] = '职业能力';
        $v['readme'] = '尊重劳动，具有积极的劳动态度和良好的劳动习惯，有独立生活的能力，具备较强职业技能和素养，参加提升职业能力类学习培训和实习实践。';
        $v['mydepth'] = 1;
        $v['pic'] = 'y';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'z';
        $v['title'] = '中';
        $v['readme'] = '了解中国，热爱中国，博取中华文化精华，积极传播中华优秀传统文化。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'zc';
        $v['title'] = '传承中国';
        $v['readme'] = '积极传承中华优秀传统文化，精通至少一项中国传统艺术项目，能理解和掌握人文思想中所蕴含的认识方法和实践方法，积极参加中华优秀传统文化类课程和活动。';
        $v['mydepth'] = 1;
        $v['pic'] = 'z';
        $v['target'] = 1;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'zz';
        $v['title'] = '中国情怀';
        $v['readme'] = '树立爱国主义思想，具有国家意识，通过实践深入中国社会实际，了解中国国情、历史和社会现实，树立对人民的感情、对国家的忠诚。';
        $v['mydepth'] = 1;
        $v['pic'] = 'z';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'w';
        $v['title'] = '外';
        $v['readme'] = '具有广博的国际视野，追求真理于世界，具备跨文化交际能力。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'wg';
        $v['title'] = '国际视野';
        $v['readme'] = '具备跨文化交际能力，了解国际通用规则，了解西方优秀文化，具备开发心态和文化、信息的吸收能力，养成“取其精华去其糟粕”的扬弃精神，具有较强信息素养，能自觉、有效地获取、评估、鉴别、使用信息。';
        $v['mydepth'] = 1;
        $v['pic'] = 'w';
        $v['target'] = 1;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'wt';
        $v['title'] = '天外气质';
        $v['readme'] = '能正确认识世界比较，在具备国际视野的前提下，能用至少一门外语正确讲述中国故事，具有国际化综合素养和完整人格。';
        $v['mydepth'] = 1;
        $v['pic'] = 'w';
        $v['target'] = 1;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'q';
        $v['title'] = '求索';
        $v['readme'] = '具有科学精神和反思能力，敢于创新，实干创业，努力探求未知世界。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'qcxcy';
        $v['title'] = '创新创业';
        $v['readme'] = '具有创新意识和创业能力和吃苦精神，在创新创业实践中取得一定成效，在创新和发明等方面有一定成绩，努力完善和提升自身发现、分析、解决问题的能力。';
        $v['mydepth'] = 1;
        $v['pic'] = 'q';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'qcxsy';
        $v['title'] = '科学素养';
        $v['readme'] = '具备较强的科学素养，能理解和掌握基本的科学原理和方法，能运用科学的思维方式认识事物、解决问题、指导实践。';
        $v['mydepth'] = 1;
        $v['pic'] = 'q';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $v['ic'] = 'j';
        $v['title'] = '竞进';
        $v['readme'] = '注重内外兼修和综合发展，具有较强的核心竞争力，以积极向上的开拓进取精神参与竞争，具有健康的人生追求。';
        $v['mydepth'] = 0;
        $v['pic'] = 0;
        $v['target'] = 0;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'jy';
        $v['title'] = '艺术修养';
        $v['readme'] = '具有艺术知识、技能与方法的积累，具有健康的审美价值取向。学习了解至少一个语言对象国的审美观念，能够借助外语交流语言对象国至少一项艺术项目的鉴赏、心得。加强艺术类课程学习，培养音乐、美术、舞蹈等艺术修为。';
        $v['mydepth'] = 1;
        $v['pic'] = 'j';
        $v['target'] = 1;
        $v['ismust'] = 0;
        $a[] = $v;

        $v['ic'] = 'js';
        $v['title'] = '身心素质';
        $v['readme'] = '具有安全意识，掌握安全技能，自觉遵守安全规范，珍爱生命，培育理性平和的心态，养成规律的作息时间和健康的生活方式，积极参加校运动会及其他各类文化体育活动，积极参加校、院组织的各类心理健康教育活动，长期坚持体育锻炼，培养一项能够终身受益的体育锻炼项目。';
        $v['mydepth'] = 1;
        $v['pic'] = 'j';
        $v['target'] = 1;
        $v['ismust'] = 1;
        $a[] = $v;

        $i = 0;
        foreach ($a as $v) {
            //$ic = app('main')->getfirstic();

            /* 暂存起自动生成的ic */
            //$a[$i]['dataic'] = $ic;

            $data = ActivityType::firstOrNew(['title' => $v['title']]);

            $data->ic = $v['ic'];
            $data->title = $v['title'];
            $data->readme = $v['readme'];

            $data->mydepth = $v['mydepth'];


            $data->pic = $v['pic'];

            $data->target = $v['target'];
            $data->ismust = $v['ismust'];


            $data->isdel = 0;
            $data->cls = 100;

            $data->save();
            $i++;
        }

        Model::reguard();
    }

    function getpic($a, $pic) {

        foreach ($a as $v) {
            if ($v['ic'] == $pic) {
                return $v['dataic'];
            }
        }
        return 0;
    }

}
