<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        DB::table('project_images')->delete(); DB::table('projects')->delete();
        DB::table('pages')->delete(); DB::table('services')->delete(); DB::table('management_members')->delete();
        foreach (DB::table('contents')->where('type', 'page')->get() as $content) {
            $meta = json_decode($content->meta ?: '{}', true);
            DB::table('pages')->updateOrInsert(['wordpress_id' => $content->wordpress_id], [
                'title' => $content->title, 'slug' => $meta['original_slug'] ?? $content->slug,
                'excerpt' => $content->excerpt, 'body' => $content->body,
                'featured_image' => $content->featured_image, 'status' => $content->status,
                'sort_order' => $content->sort_order, 'meta' => $content->meta,
                'published_at' => $content->published_at, 'created_at' => $content->created_at,
                'updated_at' => now(),
            ]);
        }

        foreach (DB::table('contents')->where('type', 'project')->get() as $content) {
            $meta = json_decode($content->meta ?: '{}', true);
            $projectId = DB::table('projects')->insertGetId([
                'wordpress_id' => $content->wordpress_id, 'title' => $content->title,
                'slug' => $meta['original_slug'] ?? $content->slug,
                'category' => $content->category ?: ($meta['category'] ?? null),
                'subtitle' => $content->excerpt, 'body' => $content->body,
                'scope_of_project' => $content->scope_of_project,
                'scope_of_services' => $content->scope_of_services,
                'status' => $content->status, 'sort_order' => $content->sort_order,
                'meta' => $content->meta, 'published_at' => $content->published_at,
                'created_at' => $content->created_at, 'updated_at' => now(),
            ]);

            $images = array_filter([$content->featured_image]);
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $content->body ?: '', $matches);
            $images = array_values(array_unique(array_merge($images, $matches[1] ?? [])));
            foreach ($images as $position => $path) {
                DB::table('project_images')->insert([
                    'project_id' => $projectId, 'path' => $path,
                    'alt_text' => $content->title, 'sort_order' => $position,
                    'is_featured' => $position === 0, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }

        $services = [
            ['Feasibility and Pre Feasibility Studies','service-feasibility.jpg',['Reconnaissance Studies','Preliminary Survey and Investigations','Development of Alternate Proposal','Design and Cost Estimates','Evaluation of Technical and Economic Feasibility']],
            ['Survey and Investigation','service-survey.jpg',['Digital Topographical Survey and Mapping','Geo-technical Investigations','Hydrological, Hydrogeological, Soil and other Services','Design and Cost Estimates','Data Analysis and Determination of Design Parameters']],
            ['Design','service-design.jpg',['Preliminary Design and Cost','Model Tests','Computer Simulations','Detailed Design and Specifications','Detailed Drawings']],
            ['Tender and Contract Documents','service-contract.jpg',['Bills of Quantities, Cost Estimates and Schedules','Preparation of Tender Documents','Pre-qualification of Contractors','Evaluation of Tender & Recommendations','Contract Documents']],
            ['Construction Supervision and Contract Management','service-supervision.jpg',['Construction Drawings','Contract Coordination','Construction Supervision and Quality Assurance and Monitoring','Certification of Periodic Payments to Contractors, Equipment Inspection and Commissioning','Legal and Contractual Advice']],
            ['Post-Construction Services','service-post-construction.jpg',['Completion Reports','Operation & Maintenance Manuals','Routine Maintenance and Safety Inspections','Performance Monitoring']],
            ['Power System Studies','service-power-system.jpg',['Load Flow Studies','Power System Stability Studies','System Fault Level Studies','Assets Evaluation','Power Tariff Studies']],
            ['Environmental & Resettlement Studies','service-environment.jpg',['Initial Environmental Examination (IEE)','Environmental Impact Assessment (EIA)','Resettlement Action Plan (RAP)']],
        ];
        foreach ($services as $order => [$title,$image,$items]) DB::table('services')->insert(['title'=>$title,'slug'=>Str::slug($title),'image'=>'assets/images/'.$image,'items'=>json_encode($items),'sort_order'=>$order,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()]);

        $members = [
            ['Engr. Muhammad Zafar','Chief Executive Officer','assets/images/management-muhammad-zafar.jpg',"M.Sc. (Electrical) University of Engineering and Technology (UET), Lahore\nB.Sc. (Electrical) Mehran University of Engineering and Technology (MUET), Jamshoro",'He served NTDC for over 36 years and retired as General Manager. In 1982 he joined WAPDA as Assistant Director (Inspection). He served in EHV construction, grid station and transmission line projects across Pakistan, including senior engineering duties with NPCC in Saudi Arabia.'],
            ['Engr. Muhammad Saleem','General Manager (Power)','assets/images/management-muhammad-saleem.jpg',"M.Sc. (Electrical), University of Engineering and Technology (UET), Lahore\nMBA University of the Punjab\nB.Sc. (Electrical) Honors, University of Engineering and Technology (UET), Lahore",'He served WAPDA, LESCO and PEPCO for 39 years and retired as General Manager. He served as Chief Executive Officer LESCO, General Manager PEPCO, Chief Engineer T&G and Technical Director LESCO, with extensive experience in distribution, operation, construction, grid stations and transmission lines.'],
            ['Engr. Abdul Samad Qureshi','GM (Water & Coordination)','assets/images/management-abdul-samad-qureshi.jpg',"M.Sc. (Irrigation/Hydraulics) Asian Institute of Technology (AIT), Bangkok, Thailand\nB.Sc. (Civil) University of Engineering and Technology (UET), Lahore",'A practicing professional engineer since 1970, he has served in LDA Water Wing, the Kano State Urban Development Board in Nigeria, and major WAPDA and BARQAAB projects. His management and consulting work includes projects funded by the World Bank, Asian Development Bank, USAID, JICA and KfW in Pakistan and overseas.'],
        ];
        foreach ($members as $order => [$name,$designation,$photo,$qualifications,$biography]) DB::table('management_members')->insert(['name'=>$name,'designation'=>$designation,'photo'=>$photo,'qualifications'=>$qualifications,'biography'=>$biography,'sort_order'=>$order,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()]);
    }

    public function down(): void
    {
        DB::table('project_images')->delete(); DB::table('projects')->delete();
        DB::table('pages')->delete(); DB::table('services')->delete(); DB::table('management_members')->delete();
    }
};
