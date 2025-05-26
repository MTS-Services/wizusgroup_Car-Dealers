<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'author_name' => 'John Doe',
            'author_designation' => 'CEO',
            'status' => Testimonial::STATUS_ACTIVE,
            'author_country' => 'USA',
            'author_image' => 'https://placehold.co/300x200',
            'quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae ultricies luctus, nunc nisl ultricies nisl, a tincidunt nisl nisl sit amet nisl.',
        ]);
        Testimonial::create([
            'author_name' => 'Mark Doe',
            'author_designation' => 'CEO',
            'status' => Testimonial::STATUS_ACTIVE,
            'author_country' => 'USA',
            'author_image' => 'https://placehold.co/300x200',
            'quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae ultricies luctus, nunc nisl ultricies nisl, a tincidunt nisl nisl sit amet nisl.',
        ]);
        Testimonial::create([
            'author_name' => 'William Doe',
            'author_designation' => 'CEO',
            'status' => Testimonial::STATUS_ACTIVE,
            'author_country' => 'USA',
            'author_image' => 'https://placehold.co/300x200',
            'quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae ultricies luctus, nunc nisl ultricies nisl, a tincidunt nisl nisl sit amet nisl.',
        ]);
        Testimonial::create([
            'author_name' => 'Lily Doe',
            'author_designation' => 'CEO',
            'status' => Testimonial::STATUS_ACTIVE,
            'author_country' => 'USA',
            'author_image' => 'https://placehold.co/300x200',
            'quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae ultricies luctus, nunc nisl ultricies nisl, a tincidunt nisl nisl sit amet nisl.',
        ]);
        Testimonial::create([
            'author_name' => 'John Doe',
            'author_designation' => 'CEO',
            'status' => Testimonial::STATUS_ACTIVE,
            'author_country' => 'USA',
            'author_image' => 'https://placehold.co/300x200',
            'quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae ultricies luctus, nunc nisl ultricies nisl, a tincidunt nisl nisl sit amet nisl.',
        ]);
    }
}
