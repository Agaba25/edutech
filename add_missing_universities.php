<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Define the missing universities
    $universities = [
        [
            'name' => 'Gulu University',
            'short_name' => 'GU',
            'short_description' => 'Northern Uganda\'s premier public university',
            'address' => 'Gulu',
            'region' => 'Northern',
            'contact_email' => 'ar@gu.ac.ug',
            'phone' => '+256-471-432921',
            'website' => 'www.gu.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2002
        ],
        [
            'name' => 'Busitema University',
            'short_name' => 'BUS',
            'short_description' => 'Multi-campus public university focusing on agriculture and engineering',
            'address' => 'Tororo',
            'region' => 'Eastern',
            'contact_email' => 'ar@acadreg.busitema.ac.ug',
            'phone' => '+256-454448842',
            'website' => 'www.busitema.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2007
        ],
        [
            'name' => 'Muni University',
            'short_name' => 'MUNI',
            'short_description' => 'Public university in West Nile region',
            'address' => 'Arua',
            'region' => 'Northern',
            'contact_email' => 'ar@muni.ac.ug',
            'phone' => '+256-476-420312',
            'website' => 'www.muni.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2013
        ],
        [
            'name' => 'Kabale University',
            'short_name' => 'KAB',
            'short_description' => 'Public university in southwestern Uganda',
            'address' => 'Kabale',
            'region' => 'Western',
            'contact_email' => 'registrar@kab.ac.ug',
            'phone' => '+256-4864-26463',
            'website' => 'www.kab.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2002
        ],
        [
            'name' => 'Lira University',
            'short_name' => 'LIRA',
            'short_description' => 'Public university in northern Uganda',
            'address' => 'Lira',
            'region' => 'Northern',
            'contact_email' => 'academicregistrar@lirauni.ac.ug',
            'phone' => '+256-471-660709',
            'website' => 'www.lirauni.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2012
        ],
        [
            'name' => 'Soroti University',
            'short_name' => 'SUN',
            'short_description' => 'Public university in eastern Uganda',
            'address' => 'Soroti',
            'region' => 'Eastern',
            'contact_email' => 'ar@sun.ac.ug',
            'phone' => '+256-454-961605',
            'website' => 'www.sun.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2015
        ],
        [
            'name' => 'Mountains of the Moon University',
            'short_name' => 'MMU',
            'short_description' => 'Public university in western Uganda',
            'address' => 'Fort Portal',
            'region' => 'Western',
            'contact_email' => 'registrar@mmu.ac.ug',
            'phone' => '+256-483-660390',
            'website' => 'www.mmu.ac.ug',
            'university_type' => 'Public',
            'established_year' => 2005
        ]
    ];
    
    echo "Adding missing universities...\n";
    
    foreach ($universities as $university) {
        // Check if university already exists
        $exists = $db->fetchOne("SELECT id FROM institutions WHERE name = ?", [$university['name']]);
        
        if (!$exists) {
            $query = "INSERT INTO institutions (name, short_name, short_description, address, region, contact_email, phone, website, university_type, established_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->execute($query, [
                $university['name'],
                $university['short_name'],
                $university['short_description'],
                $university['address'],
                $university['region'],
                $university['contact_email'],
                $university['phone'],
                $university['website'],
                $university['university_type'],
                $university['established_year']
            ]);
            
            if ($stmt) {
                echo "✓ Added " . $university['name'] . "\n";
            } else {
                echo "✗ Failed to add " . $university['name'] . "\n";
            }
        } else {
            echo "ℹ " . $university['name'] . " already exists\n";
        }
    }
    
    echo "\nAll universities processed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>