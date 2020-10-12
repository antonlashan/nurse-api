<?php

/**
 * Description of PostCommentsTableSeeder.
 *
 * @author lashanfernando
 */
use Illuminate\Database\Seeder;

class PostCommentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('post_comments')->delete();

        DB::table('post_comments')->insert([
            'post_id' => 1,
            'user_id' => 2,
            'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nibh tellus molestie nunc non blandit massa enim nec dui. Elementum pulvinar etiam non quam. Sit amet venenatis urna cursus eget nunc scelerisque.',
            'created_at' => '2019-06-06 16:31:12',
            'updated_at' => '2019-06-06 16:31:12',
        ]);
        DB::table('post_replies')->insert([
            'user_id' => 5,
            'post_comment_id' => 1,
            'comment' => 'Sed vulputate odio ut enim blandit volutpat. Nec feugiat nisl pretium fusce id velit. Ullamcorper velit sed ullamcorper morbi tincidunt ornare.',
            'created_at' => '2019-06-06 17:31:12',
            'updated_at' => '2019-06-06 17:31:12',
        ]);
        DB::table('post_replies')->insert([
            'user_id' => 4,
            'post_comment_id' => 1,
            'comment' => 'Gravida cum sociis natoque penatibus et. Nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit. Proin sed libero enim sed. Purus sit amet volutpat consequat mauris nunc congue nisi.',
            'created_at' => '2019-06-06 18:31:12',
            'updated_at' => '2019-06-06 18:31:12',
        ]);

        DB::table('post_comments')->insert([
            'post_id' => 1,
            'user_id' => 3,
            'comment' => 'Faucibus a pellentesque sit amet porttitor. Ut placerat orci nulla pellentesque dignissim enim. Ornare suspendisse sed nisi lacus. Enim neque volutpat ac tincidunt. Faucibus in ornare quam viverra orci sagittis eu volutpat.',
            'created_at' => '2019-07-06 15:31:12',
            'updated_at' => '2019-07-06 15:31:12',
        ]);

        DB::table('post_replies')->insert([
            'user_id' => 5,
            'post_comment_id' => 2,
            'comment' => 'Urna molestie at elementum eu facilisis sed. In hac habitasse platea dictumst vestibulum rhoncus est.',
            'created_at' => '2019-07-07 18:31:12',
            'updated_at' => '2019-07-07 18:31:12',
        ]);

        DB::table('post_replies')->insert([
            'user_id' => 3,
            'post_comment_id' => 2,
            'comment' => 'Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim.',
            'created_at' => '2019-07-07 19:31:12',
            'updated_at' => '2019-07-07 19:31:12',
        ]);

        DB::table('post_comments')->insert([
            'post_id' => 1,
            'user_id' => 4,
            'comment' => 'Nunc faucibus a pellentesque sit amet porttitor. Pretium lectus quam id leo in vitae turpis massa. Quam vulputate dignissim suspendisse in est ante in. Cras sed felis eget velit aliquet sagittis id.',
            'created_at' => '2019-07-03 15:31:12',
            'updated_at' => '2019-07-03 15:31:12',
        ]);
    }
}
