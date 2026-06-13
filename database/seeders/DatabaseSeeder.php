<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Announcement;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@edu.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@edu.com'],
            [
                'name' => 'Azamat Teacher',
                'password' => bcrypt('admin123'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        // Student
        User::firstOrCreate(
            ['email' => 'student@edu.com'],
            [
                'name' => 'Aigul Student',
                'password' => bcrypt('admin123'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        // Categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'HTML, CSS, JavaScript, PHP courses', 'is_active' => true],
            ['name' => 'Data Science', 'slug' => 'data-science', 'description' => 'Python, Machine Learning courses', 'is_active' => true],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development', 'description' => 'Android, iOS courses', 'is_active' => true],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'UI/UX, Figma, Photoshop courses', 'is_active' => true],
            ['name' => 'Database', 'slug' => 'database', 'description' => 'SQL, PostgreSQL, MongoDB courses', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                collect($cat)->except('slug')->toArray()
            );
        }

        // Courses — use actual DB column names (instructor_id, status) instead of virtual attributes
        $webDev = Category::where('slug', 'web-development')->first();
        $dataScience = Category::where('slug', 'data-science')->first();
        $design = Category::where('slug', 'design')->first();
        $database = Category::where('slug', 'database')->first();

        $courses = [
            ['title' => 'Laravel 11 Full Course', 'slug' => 'laravel-11-full-course', 'category_id' => $webDev->id, 'instructor_id' => $teacher->id, 'price' => 49.99, 'level' => 'beginner', 'description' => 'Learn web development with Laravel framework', 'status' => 'published'],
            ['title' => 'Python Data Science', 'slug' => 'python-data-science', 'category_id' => $dataScience->id, 'instructor_id' => $teacher->id, 'price' => 59.99, 'level' => 'intermediate', 'description' => 'Data analysis using Python', 'status' => 'published'],
            ['title' => 'React.js for Beginners', 'slug' => 'reactjs-beginners', 'category_id' => $webDev->id, 'instructor_id' => $teacher->id, 'price' => 39.99, 'level' => 'beginner', 'description' => 'Modern web applications using React.js', 'status' => 'published'],
            ['title' => 'UI/UX Design Figma', 'slug' => 'ui-ux-design-figma', 'category_id' => $design->id, 'instructor_id' => $teacher->id, 'price' => 34.99, 'level' => 'beginner', 'description' => 'Professional design using Figma', 'status' => 'published'],
            ['title' => 'PostgreSQL Databases', 'slug' => 'postgresql-databases', 'category_id' => $database->id, 'instructor_id' => $teacher->id, 'price' => 29.99, 'level' => 'beginner', 'description' => 'Database management using PostgreSQL', 'status' => 'published'],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['slug' => $course['slug']],
                collect($course)->except('slug')->toArray()
            );
        }

        // Lessons — use actual DB column names (content_text, sort_order) instead of virtual attributes
        $laravelCourse = Course::where('slug', 'laravel-11-full-course')->first();
        $pythonCourse = Course::where('slug', 'python-data-science')->first();

        $lessons = [
            ['course_id' => $laravelCourse->id, 'title' => 'Laravel Installation', 'content_text' => 'Methods of installing Laravel', 'sort_order' => 1],
            ['course_id' => $laravelCourse->id, 'title' => 'Routes and Controllers', 'content_text' => 'Working with routes and controllers', 'sort_order' => 2],
            ['course_id' => $laravelCourse->id, 'title' => 'Blade Templates', 'content_text' => 'Using Blade template engine', 'sort_order' => 3],
            ['course_id' => $pythonCourse->id, 'title' => 'Python Basics', 'content_text' => 'Python programming language', 'sort_order' => 1],
            ['course_id' => $pythonCourse->id, 'title' => 'Pandas Library', 'content_text' => 'Data processing using Pandas', 'sort_order' => 2],
        ];

        foreach ($lessons as $lesson) {
            Lesson::firstOrCreate(
                ['course_id' => $lesson['course_id'], 'title' => $lesson['title']],
                collect($lesson)->except(['course_id', 'title'])->toArray()
            );
        }

        // Announcements
        $announcements = [
            ['title' => 'EduPlatform is launched!', 'content' => 'Our platform is officially launched. You can enroll in any courses now!', 'is_active' => true],
            ['title' => 'New courses added', 'content' => 'Laravel 11 and Python Data Science courses have been added. Enroll now!', 'is_active' => true],
            ['title' => 'Student Discount', 'content' => 'There is a 20% discount on all courses this month!', 'is_active' => true],
        ];

        foreach ($announcements as $ann) {
            Announcement::firstOrCreate(
                ['title' => $ann['title']],
                collect($ann)->except('title')->toArray()
            );
        }

        // Programming Languages
        $languages = [
            ['name' => 'Python', 'slug' => 'python', 'version' => '3.10', 'monaco_language' => 'python', 'file_extension' => 'py', 'is_active' => true],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'version' => 'ES6', 'monaco_language' => 'javascript', 'file_extension' => 'js', 'is_active' => true],
            ['name' => 'PHP', 'slug' => 'php', 'version' => '8.2', 'monaco_language' => 'php', 'file_extension' => 'php', 'is_active' => true],
            ['name' => 'C++', 'slug' => 'cpp', 'version' => 'GCC 11', 'monaco_language' => 'cpp', 'file_extension' => 'cpp', 'is_active' => true],
            ['name' => 'Java', 'slug' => 'java', 'version' => 'JDK 17', 'monaco_language' => 'java', 'file_extension' => 'java', 'is_active' => true],
        ];

        foreach ($languages as $lang) {
            \App\Models\ProgrammingLanguage::firstOrCreate(
                ['slug' => $lang['slug']],
                collect($lang)->except('slug')->toArray()
            );
        }
    }
}
