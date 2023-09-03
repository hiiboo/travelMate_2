<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Article;
use App\Models\Organizer;
use App\Models\Event;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $organizers = Organizer::all();
        $events = Event::all()->pluck('id')->toArray();
        return [
            'organizer_id' => $this->faker->randomElement($organizers)->id,
            'title' => $this->faker->randomElement([
                '春の訪れ',
                '夏の冒険',
                '秋の思い出',
                '失われた時間',
                '夜空に輝く星',
                '秘密の森',
            ]),
            'event_id' => $this->faker->randomElement($events),
            'content' => $this->faker->randomElement([
                '春は、新しい生活が始まる季節だ。桜の花が咲き、街はピンク色に染まる。私はこの時期、新しい出会いと別れを経験することで、自分自身を見つめ直す機会になると感じる。',
                '夏は、冒険の季節だ。学校は長い休みに入り、家族や友達と過ごす時間が増える。私はこの時期、新しい場所に行ったり、未知のことに挑戦したりすることで、自分を成長させる機会になると感じる。',
                '秋は、過去を思い出す季節だ。木々の葉が色づき、街はオレンジ色に染まる。私はこの時期、過去の思い出を振り返りながら、自分の人生を再評価する機会になると感じる。',
                '時間は一度失われると取り戻すことはできない。私は最近、時間の大切さについて改めて考える機会があった。友人との約束をすっぽかし、そのことで友人に迷惑をかけてしまったからだ。',
                '夜空には数え切れないほどの星が輝いている。私は子供の頃、父と一緒に星座を見つけることが好きだった。その思い出は今でも私の心に残っていて、星空を見上げるたびに父のことを思い出す。',
                '私の家の近くには、人々があまり足を踏み入れない森がある。私はその森に入って、自分だけの秘密の場所を見つけた。そこは私にとって、現実逃避をする場所となっている。',
            ]),

            'status' => $this->faker->randomElement(['DRAFT', 'PUBLISHED', 'ARCHIVED']),
        ];
    }
}
