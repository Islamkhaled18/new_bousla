<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_titles')->delete();

        $jobs = [
            ['id' => 1, 'name' => 'جِلْدِيَّة', 'name_en' => 'Dermatology', 'slug' => 'dermatology', 'icon' => 'fa-hand-sparkles', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 2, 'name' => 'أَسْنَان', 'name_en' => 'Dentistry', 'slug' => 'dentistry', 'icon' => 'fa-tooth', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 3, 'name' => 'نَفْسِيّ', 'name_en' => 'Psychiatry', 'slug' => 'psychiatry', 'icon' => 'fa-brain', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 4, 'name' => 'أَطْفَال وَحَدِيثِي الْوِلَادَة', 'name_en' => 'Pediatrics & Neonatology', 'slug' => 'pediatrics-neonatology', 'icon' => 'fa-baby', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 5, 'name' => 'مُخّ وَأَعْصَاب', 'name_en' => 'Neurology', 'slug' => 'neurology', 'icon' => 'fa-brain', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 6, 'name' => 'عِظَام', 'name_en' => 'Orthopedics', 'slug' => 'orthopedics', 'icon' => 'fa-bone', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 7, 'name' => 'نِسَاء وَتَوْلِيد', 'name_en' => 'Obstetrics & Gynecology', 'slug' => 'obstetrics-gynecology', 'icon' => 'fa-person-dress', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 8, 'name' => 'أَنْف وَأُذُن وَحَنْجَرَة', 'name_en' => 'ENT', 'slug' => 'ent', 'icon' => 'fa-ear-listen', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 9, 'name' => 'قَلْب وَأَوْعِيَة دَمَوِيَّة', 'name_en' => 'Cardiology & Vascular', 'slug' => 'cardiology-vascular', 'icon' => 'fa-heart-pulse', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 10, 'name' => 'بَاطِنَة', 'name_en' => 'Internal Medicine', 'slug' => 'internal-medicine', 'icon' => 'fa-stethoscope', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 11, 'name' => 'الأَشِعَّة التَّدَاخُلِيَّة', 'name_en' => 'Interventional Radiology', 'slug' => 'interventional-radiology', 'icon' => 'fa-x-ray', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 12, 'name' => 'أَمْرَاض دَم', 'name_en' => 'Hematology', 'slug' => 'hematology', 'icon' => 'fa-droplet', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 13, 'name' => 'أَوْرَام', 'name_en' => 'Oncology', 'slug' => 'oncology', 'icon' => 'fa-ribbon', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 14, 'name' => 'تَخْسِيس وَتَغْذِيَة', 'name_en' => 'Weight Loss & Nutrition', 'slug' => 'weight-loss-nutrition', 'icon' => 'fa-apple-whole', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 15, 'name' => 'جِرَاحَة أَطْفَال', 'name_en' => 'Pediatric Surgery', 'slug' => 'pediatric-surgery', 'icon' => 'fa-user-nurse', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 16, 'name' => 'جِرَاحَة أَوْرَام', 'name_en' => 'Oncologic Surgery', 'slug' => 'oncologic-surgery', 'icon' => 'fa-scissors', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 17, 'name' => 'جِرَاحَة أَوْعِيَة دَمَوِيَّة', 'name_en' => 'Vascular Surgery', 'slug' => 'vascular-surgery', 'icon' => 'fa-heart-circle-bolt', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 18, 'name' => 'جِرَاحَة تَجْمِيل', 'name_en' => 'Plastic Surgery', 'slug' => 'plastic-surgery', 'icon' => 'fa-face-smile', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 19, 'name' => 'جِرَاحَة سِمْنَة وَمَنَاظِير', 'name_en' => 'Bariatric & Laparoscopic Surgery', 'slug' => 'bariatric-laparoscopic-surgery', 'icon' => 'fa-weight-scale', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 20, 'name' => 'جِرَاحَة عَامَّة', 'name_en' => 'General Surgery', 'slug' => 'general-surgery', 'icon' => 'fa-user-doctor', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 21, 'name' => 'جِرَاحَة عَمُود فِقْرِي', 'name_en' => 'Spine Surgery', 'slug' => 'spine-surgery', 'icon' => 'fa-person', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 22, 'name' => 'جِرَاحَة قَلْب وَصَدْر', 'name_en' => 'Cardiothoracic Surgery', 'slug' => 'cardiothoracic-surgery', 'icon' => 'fa-lungs', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 23, 'name' => 'جِرَاحَة مُخّ وَأَعْصَاب', 'name_en' => 'Neurosurgery', 'slug' => 'neurosurgery', 'icon' => 'fa-head-side-virus', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 24, 'name' => 'جِهَاز هَضْمِي وَمَنَاظِير', 'name_en' => 'Gastroenterology & Endoscopy', 'slug' => 'gastroenterology-endoscopy', 'icon' => 'fa-pills', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 25, 'name' => 'حَسَاسِيَّة وَمَنَاعَة', 'name_en' => 'Allergy & Immunology', 'slug' => 'allergy-immunology', 'icon' => 'fa-shield-virus', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 26, 'name' => 'حَقْن مِجْهَرِي وَأَطْفَال أَنْابِيب', 'name_en' => 'IVF & Infertility', 'slug' => 'ivf-infertility', 'icon' => 'fa-baby-carriage', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 28, 'name' => 'ذُكُورَة وَعُقْم', 'name_en' => 'Andrology & Infertility', 'slug' => 'andrology-infertility', 'icon' => 'fa-person', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 29, 'name' => 'رُومَاتِيزِم', 'name_en' => 'Rheumatology', 'slug' => 'rheumatology', 'icon' => 'fa-hand-dots', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 30, 'name' => 'سُكَّر وَغُدَد صَمَّاء', 'name_en' => 'Endocrinology & Diabetes', 'slug' => 'endocrinology-diabetes', 'icon' => 'fa-syringe', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 31, 'name' => 'سَمْعِيَّات', 'name_en' => 'Audiology', 'slug' => 'audiology', 'icon' => 'fa-deaf', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 32, 'name' => 'صَدْر وَجِهَاز تَنَفُّسِي', 'name_en' => 'Pulmonology', 'slug' => 'pulmonology', 'icon' => 'fa-lungs', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 33, 'name' => 'طِبّ الأُسْرَة', 'name_en' => 'Family Medicine', 'slug' => 'family-medicine', 'icon' => 'fa-people-roof', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 34, 'name' => 'طِبّ الْمُسِنِّين', 'name_en' => 'Geriatrics', 'slug' => 'geriatrics', 'icon' => 'fa-person-cane', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 35, 'name' => 'طِبّ بَيْطَرِي', 'name_en' => 'Veterinary Medicine', 'slug' => 'veterinary-medicine', 'icon' => 'fa-paw', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 36, 'name' => 'طِبّ تَقْوِيمِي', 'name_en' => 'Orthodontics', 'slug' => 'orthodontics', 'icon' => 'fa-teeth', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 37, 'name' => 'عِلَاج طَبِيعِي وَإِصَابَات مَلَاعِب', 'name_en' => 'Physiotherapy & Sports Injuries', 'slug' => 'physiotherapy-sports-injuries', 'icon' => 'fa-person-walking', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 38, 'name' => 'عُيُون', 'name_en' => 'Ophthalmology', 'slug' => 'ophthalmology', 'icon' => 'fa-eye-dropper', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 39, 'name' => 'كَبِد', 'name_en' => 'Hepatology', 'slug' => 'hepatology', 'icon' => 'fa-heartbeat', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 40, 'name' => 'كُلْيَة', 'name_en' => 'Nephrology', 'slug' => 'nephrology', 'icon' => 'fa-prescription-bottle-medical', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 41, 'name' => 'مَسَالِك بَوْلِيَّة', 'name_en' => 'Urology', 'slug' => 'urology', 'icon' => 'fa-venus-mars', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
            ['id' => 42, 'name' => 'نُطْق وَتَخَاطُب', 'name_en' => 'Speech Therapy', 'slug' => 'speech-therapy', 'icon' => 'fa-comments', 'icon_color' => '#00B6B0', 'bg_color' => '#E6F7F6'],
        ];

        foreach ($jobs as $job) {
            JobTitle::create($job);
        }
    }
}
