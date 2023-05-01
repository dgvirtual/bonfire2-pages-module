<?php

namespace App\Modules\Pages\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertSamplePages extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'First Page',
                'content'    => 'Nulla a nunc vel purus porta finibus. Aenean porta dui vel tellus pulvinar congue. Nunc egestas iaculis nunc, ut efficitur nisi pellentesque vel. Quisque pharetra, metus eu malesuada fringilla, felis leo efficitur orci, non varius mauris ex sed felis. Vestibulum posuere tortor at augue mattis efficitur. Nulla aliquet fermentum nibh sit amet tristique. Fusce tempor metus vel purus imperdiet facilisis. Curabitur eu cursus odio, in tristique ex. Phasellus in eros lectus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec feugiat nisi quam, eu euismod dolor mattis quis. Fusce congue, metus vitae venenatis laoreet, eros sapien rhoncus urna, porta rhoncus nisi risus sed lectus. Donec eleifend vel enim vitae convallis. Vestibulum ante sapien, maximus ut metus nec, egestas posuere sapien. ',
                'excerpt'   => 'Nulla a nunc vel purus porta finibus. Aenean porta dui vel tellus pulvinar congue...',
                'slug'  => 'first-page',
                'category' => 'News',
                'created_at' => date('Y-m-d H:i:s',strtotime("-4 days")),
                'updated_at' => date('Y-m-d H:i:s',strtotime("-4 days")),
            ],
            [
                'title' => 'Second Page',
                'content'    => 'In auctor nisl id tellus pharetra, in porttitor ipsum laoreet. Maecenas vulputate odio id laoreet cursus. Cras venenatis sollicitudin blandit. Praesent sed massa mauris. Phasellus eu eros nisl. Integer pretium vitae purus at dignissim. In consequat vestibulum malesuada. Donec accumsan quam leo, vestibulum viverra est tincidunt sed. Suspendisse et lorem vestibulum, ultricies nibh ut, vehicula velit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ',
                'excerpt'   => 'In auctor nisl id tellus pharetra, in porttitor ipsum laoreet. Maecenas vulputate odio...',
                'slug'  => 'second-page',
                'category' => 'Page',
                'created_at' => date('Y-m-d H:i:s',strtotime("-3 days")),
                'updated_at' => date('Y-m-d H:i:s',strtotime("-3 days")),
            ],
            [
                'title' => 'Third Page',
                'content'    => 'Nam fermentum porttitor neque, vel condimentum erat pharetra id. Aliquam purus lacus, ultrices quis imperdiet nec, mollis sit amet nunc. Morbi tristique nec turpis vitae cursus. Etiam tempus malesuada nulla, id faucibus nibh pharetra sit amet. Nulla facilisi. Sed vestibulum tellus at aliquam convallis. Etiam tortor tortor, mattis non felis et, pharetra posuere magna. Donec lobortis dolor eu lectus malesuada elementum. Mauris condimentum enim vel luctus luctus. Aliquam quis consequat mauris. Sed ut neque a nisi porta ultricies. Suspendisse ac ligula quis libero mattis accumsan sed in elit. Sed sed nisi iaculis, congue mi vel, aliquam dui. Sed id urna dictum, ullamcorper tortor malesuada, consequat nunc. ',
                'excerpt'   => 'Nam fermentum porttitor neque, vel condimentum erat pharetra id. Aliquam purus lacus...',
                'slug'  => 'third-page',
                'category' => 'Article',
                'created_at' => date('Y-m-d H:i:s',strtotime("-2 days")),
                'updated_at' => date('Y-m-d H:i:s',strtotime("-2 days")),
            ],
            [
                'title' => 'Fourth Page',
                'content'    => 'Sed vestibulum tellus at aliquam convallis. Etiam tortor tortor, mattis non felis et, pharetra posuere magna. Donec lobortis dolor eu lectus malesuada elementum. Mauris condimentum enim vel luctus luctus. Aliquam quis consequat mauris. Sed ut neque a nisi porta ultricies. Suspendisse ac ligula quis libero mattis accumsan sed in elit. Sed sed nisi iaculis, congue mi vel, aliquam dui. Sed id urna dictum, ullamcorper tortor malesuada, consequat nunc. Nam fermentum porttitor neque, vel condimentum erat pharetra id. Aliquam purus lacus, ultrices quis imperdiet nec, mollis sit amet nunc. Morbi tristique nec turpis vitae cursus. Etiam tempus malesuada nulla, id faucibus nibh pharetra sit amet. Nulla facilisi. ',
                'excerpt'   => 'Sed vestibulum tellus at aliquam convallis. Etiam tortor tortor, mattis non felis et...',
                'slug'  => 'fourth-page',
                'category' => 'Article',
                'created_at' => date('Y-m-d H:i:s',strtotime("-1 day")),
                'updated_at' => date('Y-m-d H:i:s',strtotime("-1 day")),
            ],
        ];

        $this->db->table('pages')->insertBatch($data);

        // or: 
        // $builder = $this->db->table('pages');
        // foreach ($data as $page) {
        //     $builder->insert($page);
        // }
    }
}
