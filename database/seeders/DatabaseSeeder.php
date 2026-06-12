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
        if (!User::where('email', 'admin@edu.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@edu.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }
        
        // Teacher
        if (!User::where('email', 'teacher@edu.com')->exists()) {
            User::create([
                'name' => 'Azamat Teacher',
                'email' => 'teacher@edu.com',
                'password' => bcrypt('admin123'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);
        }
        
        // Student
        if (!User::where('email', 'student@edu.com')->exists()) {
            User::create([
                'name' => 'Aigul Student',
                'email' => 'student@edu.com',
                'password' => bcrypt('admin123'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);
        }

        // Categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'HTML, CSS, JavaScript, PHP courses', 'is_active' => true],
            ['name' => 'Data Science', 'slug' => 'data-science', 'description' => 'Python, Machine Learning courses', 'is_active' => true],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development', 'description' => 'Android, iOS courses', 'is_active' => true],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'UI/UX, Figma, Photoshop courses', 'is_active' => true],
            ['name' => 'Database', 'slug' => 'database', 'description' => 'SQL, PostgreSQL, MongoDB courses', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Courses
        $courses = [
            ['title' => 'Laravel 11 Full Course', 'slug' => 'laravel-11-full-course', 'category_id' => 1, 'user_id' => 2, 'price' => 49.99, 'level' => 'beginner', 'description' => 'Learn web development with Laravel framework', 'is_active' => true],
            ['title' => 'Python Data Science', 'slug' => 'python-data-science', 'category_id' => 2, 'user_id' => 2, 'price' => 59.99, 'level' => 'intermediate', 'description' => 'Data analysis using Python', 'is_active' => true],
            ['title' => 'React.js for Beginners', 'slug' => 'reactjs-beginners', 'category_id' => 1, 'user_id' => 2, 'price' => 39.99, 'level' => 'beginner', 'description' => 'Modern web applications using React.js', 'is_active' => true],
            ['title' => 'UI/UX Design Figma', 'slug' => 'ui-ux-design-figma', 'category_id' => 4, 'user_id' => 2, 'price' => 34.99, 'level' => 'beginner', 'description' => 'Professional design using Figma', 'is_active' => true],
            ['title' => 'PostgreSQL Databases', 'slug' => 'postgresql-databases', 'category_id' => 5, 'user_id' => 2, 'price' => 29.99, 'level' => 'beginner', 'description' => 'Database management using PostgreSQL', 'is_active' => true],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }

        // Lessons
        $lessons = [
            ['course_id' => 1, 'title' => 'Laravel Installation', 'content' => 'Methods of installing Laravel', 'order' => 1, 'is_active' => true],
            ['course_id' => 1, 'title' => 'Routes and Controllers', 'content' => 'Working with routes and controllers', 'order' => 2, 'is_active' => true],
            ['course_id' => 1, 'title' => 'Blade Templates', 'content' => 'Using Blade template engine', 'order' => 3, 'is_active' => true],
            ['course_id' => 2, 'title' => 'Python Basics', 'content' => 'Python programming language', 'order' => 1, 'is_active' => true],
            ['course_id' => 2, 'title' => 'Pandas Library', 'content' => 'Data processing using Pandas', 'order' => 2, 'is_active' => true],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }

        // Announcements
        $announcements = [
            ['title' => 'EduPlatform is launched!', 'content' => 'Our platform is officially launched. You can enroll in any courses now!', 'is_active' => true],
            ['title' => 'New courses added', 'content' => 'Laravel 11 and Python Data Science courses have been added. Enroll now!', 'is_active' => true],
            ['title' => 'Student Discount', 'content' => 'There is a 20% discount on all courses this month!', 'is_active' => true],
        ];

        foreach ($announcements as $ann) {
            Announcement::create($ann);
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
            \App\Models\ProgrammingLanguage::create($lang);
        }
    }
}
