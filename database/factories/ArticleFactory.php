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
            ]),
            'event_id' => $this->faker->randomElement($events),
            'content' => $this->faker->randomElement([
                '春は、新しい生活が始まる季節だ。桜の花が咲き、街はピンク色に染まる。私はこの時期、新しい出会いと別れを経験することで、自分自身を見つめ直す機会になると感じる。',
                '夏は、冒険の季節だ。学校は長い休みに入り、家族や友達と過ごす時間が増える。私はこの時期、新しい場所に行ったり、未知のことに挑戦したりすることで、自分を成長させる機会になると感じる。',
                '秋は、過去を思い出す季節だ。木々の葉が色づき、街はオレンジ色に染まる。私はこの時期、過去の思い出を振り返りながら、自分の人生を再評価する機会になると感じる。',
            ]),

            'status' => $this->faker->randomElement(['DRAFT', 'PUBLISHED', 'ARCHIVED']),
        ];
    }
}
