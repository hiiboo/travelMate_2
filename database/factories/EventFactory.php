<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Organizer;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $organizers = Organizer::all()->pluck('id')->toArray();

        $eventTitles = [
            '星空の宴',
            '歴史を巡る旅',
            '手作りアートフェア',
            'リズムのフェスティバル',
            '都市のサステナビリティカンファレンス',
            '料理の祭典',
            '文学の夜',
            'テクノロジーショーケース',
        ];

        $eventDescriptions = [
            '夜の公園での屋外映画イベント。参加者はブランケットを持参し、都市の喧騒から離れて映画を楽しむことができます。',
            '地域の歴史的な建物やランドマークを訪れるツアー。ガイドが歴史的な背景や面白いエピソードを紹介します。',
            '地元のアーティストや職人が自作のアートや工芸品を展示・販売するイベント。ワークショップやライブパフォーマンスも行われます。',
            '異なる文化や国の伝統的なダンスや音楽が一堂に会する祭り。参加者もダンスワークショップに参加して、新しいリズムや動きを学ぶことができます。',
            '環境や持続可能性に関する専門家が一同に会し、新しい技術やアイディアを共有するカンファレンス。ワークショップやパネルディスカッションが行われます。',
            '地元の料理人や料理愛好者が一堂に会し、伝統的な料理や新しいレシピを紹介。実際に料理を味わうこともできる。',
            '地元の作家や詩人が自作を朗読する夜。参加者は自分の作品を共有することもでき、文学に関するディスカッションも楽しめる。',
            '最新の技術やガジェットを展示するイベント。VRやAIなどのデモンストレーションもあり、技術者とのQ&Aセッションも行われる。',
        ];

        $status = [
            'published',
            'draft',
            'ended',
        ];

        return [
            'title' => $this->faker->randomElement($eventTitles),
            'description' => $this->faker->randomElement($eventDescriptions),
            'event_image_path' => $this->faker->imageUrl(),
            'organizer_id' => $this->faker->randomElement($organizers),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'name' => $this->faker->city(),
            'address' => $this->faker->address(),
            'status' => $this->faker->randomElement($status),
        ];
    }
}
