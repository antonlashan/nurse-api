<?php
/**
 * Description of CompaniesTableSeeder.
 *
 * @author lashanfernando
 */
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\CompanyPost;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('companies')->delete();

        $company = Company::create(['name' => 'Asiri Hospital Holdings Pvt Ltd', 'logo' => '111111.jpg', 'banner' => '222222.jpg', 'address' => 'Colombo 5', 'phone' => '2575637401', 'email' => 'test@chapman.com']);
        CompanyPost::create(['company_id' => $company->id, 'position' => 'Nurse (Female/Male) - Colombo 5', 'description' => 'ශ්‍රී ලාංකික පෞද්ගලික රෝහල් ක්‍ෂේත්‍රයේ සාඩම්බර පෙරගමන්කරුවා මෙන්ම විශාලතම පෞද්ගලික රෝහල් ජාලයේ හිමිකාරිත්වය දරණ " අසිරි රෝහල් සමූහය ", නවීනතම තාක්ෂණය සමඟ අති දක්‍ෂ කාර්ය මණ්ඩලයකින් සමන්විතව උසස් සෞඛ්‍ය සේවාවක් ජාතියට දායාද කරයි.

        ශ්‍රී ලංකික පෞද්ගලික රෝහල් සේවාව තුළ අප සතු විශේෂත්වයද වන්නේ අති දක්‍ෂ කාර්ය මණ්ඩලයක් අප සතු වීමයි.
        
        එවැනි විශිෂ්ට සුහදශීලි කාර්ය මණ්ඩලයට එක් වීම සඳහා ඔබටත් අනගි අවස්ථාවක්.
        
        # තනතුර : හෙද / හෙදියන් (NURSES)
        ===========================
        
        # සුදුසුකම් :
        
        ~ ඔබත් පහත සඳහන් ඒකකයන්හි පළපුරුද්ද සහිත, 
        ~ රජයේ හෙද විදුහලක හෝ පිළිගත් පෞද්ගලික හෙද විදුහලක වසර තුනක හෙද පාඨමාලාවක් හදාරා ඇති
        
        හෙද හෙදියක්නම් අදම අයඳුම් කරන්න.
        
        ### ශල්‍යාගාර සේවා ( OPERATION THEATRE )
        ### දැඩි සත්කාර සේවා ( ICU AND SICU )
        
        # ප්‍රතිලාභ :
        
        ආකර්ශනීය වැටුපක් සහ අනෙකුත් වරප්‍රසාද රැසක් පිරිනැමේ.
        
        # ඉල්ලුම් කළ යුතු ආකාරය :
        
        ඉහත තනතුර සඳහා සුදුසූම පුද්ගලයා ඔබ නම්, මෙම දැන්වීමේ "Apply for this job" හරහා අයඳුම් කරන්න.
        
        හෝ
        
        ඔබගේ අයඳුම්පත් 2019 ජුනි මස 09 වන දිනට පෙර පහත ලිපිනයට එවන්න.
        [ අයඳුම් කරන තනතුර ලියුම් කවරයේ ඉහළ වම් කෙළවරේ සඳහන් කරන්න. ]
        
        අධ්‍යක්‍ෂිකා - මානව සම්පත්,
        මානව සම්පත් අංශය,
        ආසිරි ශල්‍ය රෝහල,
        අංක 21, කිරිමණ්ඩල මාවත, කොළඹ 05.']);

        DB::table('company_post_bookmarks')->insert(['company_post_id' => 1, 'user_id' => 2]);
        DB::table('company_post_applications')->insert(['company_post_id' => 1, 'user_id' => 2]);

        $company = Company::create(['name' => 'Wellfort Management Pvt Ltd', 'logo' => '222222.jpg', 'banner' => '111111.jpg', 'address' => 'Colombo', 'phone' => '0777222963', 'email' => 'test@wellfort.com']);
        CompanyPost::create(['company_id' => $company->id, 'position' => 'Female Executive - Nugegoda', 'description' => 'Executive - Operations තනතුර සඳහා මිරිහානේ පිහිටි ලංකාවේ ප්‍රමුඛතම සමාගම් ජාලයක කාන්තා ඇබෑර්තු 2ක් ඇත.

        කොන්දේසි, පහසුකම් හා වරප්‍රසාද:
        - වයස අවු 30 ඉක්මවිය යුතුය.
        - අවම වශයෙන් වසර දෙකක සේවා පලපුරුද්දක් තිබිය යුතුය. 
        - කාන්තාවන් පමණක් වන සේවා පරිසරය. 
        - EPF, ETF ඇතුලත්ව වැටුප රු30,000/= සිට රු40,000/= දක්වා.
        
        තනතුරේ ස්වභාවය: 
        - දුරකතන, email හා social media ඔස්සේ පාරිභෝගිකයන් හා සම්භන්ධ වී අවශ්‍ය පහසුකම් සලසා දීම. 
        - අදාල කාර්‍යාලීය මෙහෙයුම් කටයුතු සිදු කිරීම.
        
        සතියේ දවස්වල උදෑසන 9-12 අතර සම්පුර්ණ කරන ලද CV එකක් සමඟ සම්මුඛ පරීක්ෂණයට පැමිණෙන්න.
        
        ලිපිනය: 22/2A, පැඟිරිවත්ත මාවත, මිරිහාන, නුගේගොඩ. (119 බසයේ පැමිණ "තිලක බේකරිය" ගාව බහින්න.)
        
        වැඩි විස්තර සඳහා අමතන්න. කුමුදු
        
        ']);

        DB::table('company_post_bookmarks')->insert(['company_post_id' => 2, 'user_id' => 2]);
        DB::table('company_post_applications')->insert(['company_post_id' => 2, 'user_id' => 2]);
    }
}
