<?php
/**
 * Import University Data Script
 * This script imports the extracted university data into the database
 */

require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/EnhancedProgram.php';

// Check if running from command line or web
$is_cli = php_sapi_name() === 'cli';

if (!$is_cli) {
    // Web interface
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Import University Data - EduTech</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h1>Import University Data</h1>
            <div class="alert alert-warning">
                <strong>Warning:</strong> This will import sample data. Make sure to backup your database first.
            </div>
    <?php
}

try {
    $db = Database::getInstance();
    $enhanced_program = new EnhancedProgram();
    
    echo $is_cli ? "Starting data import...\n" : '<div class="alert alert-info">Starting data import...</div>';
    
    // Check if database exists and create tables
    $db->execute("CREATE DATABASE IF NOT EXISTS `edutech_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $db->execute("USE `edutech_db`");
    
    // Read and execute the enhanced database schema
    $schema_sql = file_get_contents(__DIR__ . '/database_enhanced.sql');
    $statements = explode(';', $schema_sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^(CREATE DATABASE|USE)/i', $statement)) {
            try {
                $db->execute($statement);
            } catch (Exception $e) {
                // Ignore errors for existing tables/data
                if ($is_cli) {
                    echo "Warning: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo $is_cli ? "Database schema created/updated successfully.\n" : '<div class="alert alert-success">Database schema created/updated successfully.</div>';
    
    // Import additional programs data
    $additional_programs = [
        // Makerere University additional programs
        [
            'institution_id' => 1,
            'program_code' => 'BBA',
            'level' => 'Bachelor',
            'name' => 'Bachelor of Business Administration',
            'duration' => '3 Years',
            'duration_years' => 3,
            'fee_estimate' => '8,000,000 UGX',
            'cutoff_info' => 'Minimum: Mathematics and Economics at A-Level',
            'description' => 'Comprehensive business administration program',
            'faculty' => 'College of Business and Management Sciences',
            'essential_subjects' => 'Mathematics, Economics',
            'relevant_subjects' => 'Literature, History, Geography',
            'desirable_subjects' => 'General Paper, Computer Studies',
            'cutoff_points_2023' => 42.5,
            'cutoff_points_2022' => 35.2,
            'cutoff_points_2021' => 38.7,
            'sponsorship_type' => 'Government',
            'application_fee' => 52000
        ],
        [
            'institution_id' => 1,
            'program_code' => 'BCOM',
            'level' => 'Bachelor',
            'name' => 'Bachelor of Commerce',
            'duration' => '3 Years',
            'duration_years' => 3,
            'fee_estimate' => '8,000,000 UGX',
            'cutoff_info' => 'Minimum: Mathematics and Economics at A-Level',
            'description' => 'Commerce and accounting program',
            'faculty' => 'College of Business and Management Sciences',
            'essential_subjects' => 'Mathematics, Economics',
            'relevant_subjects' => 'Literature, History, Geography',
            'desirable_subjects' => 'General Paper, Computer Studies',
            'cutoff_points_2023' => 41.8,
            'cutoff_points_2022' => 34.5,
            'cutoff_points_2021' => 37.9,
            'sponsorship_type' => 'Government',
            'application_fee' => 52000
        ],
        [
            'institution_id' => 1,
            'program_code' => 'BEC',
            'level' => 'Bachelor',
            'name' => 'Bachelor of Economics',
            'duration' => '3 Years',
            'duration_years' => 3,
            'fee_estimate' => '8,000,000 UGX',
            'cutoff_info' => 'Minimum: Mathematics and Economics at A-Level',
            'description' => 'Economics and policy analysis program',
            'faculty' => 'College of Business and Management Sciences',
            'essential_subjects' => 'Mathematics, Economics',
            'relevant_subjects' => 'Literature, History, Geography',
            'desirable_subjects' => 'General Paper, Computer Studies',
            'cutoff_points_2023' => 43.2,
            'cutoff_points_2022' => 36.1,
            'cutoff_points_2021' => 39.4,
            'sponsorship_type' => 'Government',
            'application_fee' => 52000
        ],
        [
            'institution_id' => 1,
            'program_code' => 'BED',
            'level' => 'Bachelor',
            'name' => 'Bachelor of Education',
            'duration' => '3 Years',
            'duration_years' => 3,
            'fee_estimate' => '6,000,000 UGX',
            'cutoff_info' => 'Minimum: Two principal passes at A-Level',
            'description' => 'Education and teaching program',
            'faculty' => 'School of Education',
            'essential_subjects' => 'Any two subjects',
            'relevant_subjects' => 'Literature, History, Geography, Mathematics',
            'desirable_subjects' => 'General Paper, Computer Studies',
            'cutoff_points_2023' => 38.7,
            'cutoff_points_2022' => 32.4,
            'cutoff_points_2021' => 35.8,
            'sponsorship_type' => 'Government',
            'application_fee' => 52000
        ],
        [
            'institution_id' => 1,
            'program_code' => 'BLAW',
            'level' => 'Bachelor',
            'name' => 'Bachelor of Laws',
            'duration' => '4 Years',
            'duration_years' => 4,
            'fee_estimate' => '10,000,000 UGX',
            'cutoff_info' => 'Minimum: Two principal passes at A-Level',
            'description' => 'Law and legal studies program',
            'faculty' => 'School of Law',
            'essential_subjects' => 'Any two subjects',
            'relevant_subjects' => 'Literature, History, Geography, Economics',
            'desirable_subjects' => 'General Paper, Computer Studies',
            'cutoff_points_2023' => 45.6,
            'cutoff_points_2022' => 38.9,
            'cutoff_points_2021' => 42.1,
            'sponsorship_type' => 'Government',
            'application_fee' => 52000
        ]
    ];
    
    $imported_count = 0;
    foreach ($additional_programs as $program_data) {
        try {
            $program_id = $enhanced_program->create($program_data);
            if ($program_id) {
                $imported_count++;
                echo $is_cli ? "Imported: " . $program_data['name'] . "\n" : '';
            }
        } catch (Exception $e) {
            echo $is_cli ? "Error importing " . $program_data['name'] . ": " . $e->getMessage() . "\n" : '';
        }
    }
    
    // Add subject combinations for existing programs
    $subject_combinations = [
        // Medicine combinations
        ['program_id' => 1, 'combination_code' => 'PCB', 'subject_1' => 'Physics', 'subject_2' => 'Chemistry', 'subject_3' => 'Biology', 'description' => 'Traditional science combination'],
        ['program_id' => 1, 'combination_code' => 'PCM', 'subject_1' => 'Physics', 'subject_2' => 'Chemistry', 'subject_3' => 'Mathematics', 'description' => 'Science with mathematics'],
        
        // Engineering combinations
        ['program_id' => 3, 'combination_code' => 'PCM', 'subject_1' => 'Physics', 'subject_2' => 'Chemistry', 'subject_1' => 'Mathematics', 'description' => 'Core engineering subjects'],
        ['program_id' => 3, 'combination_code' => 'PCE', 'subject_1' => 'Physics', 'subject_2' => 'Chemistry', 'subject_3' => 'Economics', 'description' => 'Engineering with economics'],
        
        // Business combinations
        ['program_id' => 6, 'combination_code' => 'MEC', 'subject_1' => 'Mathematics', 'subject_2' => 'Economics', 'subject_3' => 'Chemistry', 'description' => 'Business with science background'],
        ['program_id' => 6, 'combination_code' => 'MEH', 'subject_1' => 'Mathematics', 'subject_2' => 'Economics', 'subject_3' => 'History', 'description' => 'Business with arts background'],
    ];
    
    foreach ($subject_combinations as $combination) {
        try {
            $db->execute(
                'INSERT INTO subject_combinations (program_id, combination_code, subject_1, subject_2, subject_3, description) VALUES (?, ?, ?, ?, ?, ?)',
                [$combination['program_id'], $combination['combination_code'], $combination['subject_1'], $combination['subject_2'], $combination['subject_3'], $combination['description']]
            );
        } catch (Exception $e) {
            // Ignore duplicate entries
        }
    }
    
    echo $is_cli ? "Import completed successfully!\n" : '<div class="alert alert-success">Import completed successfully!</div>';
    echo $is_cli ? "Imported $imported_count additional programs.\n" : "<p>Imported $imported_count additional programs.</p>";
    
    // Display statistics
    $stats = $enhanced_program->getStatistics();
    echo $is_cli ? "Total programs: " . $stats['total_programs'] . "\n" : "<p>Total programs: " . $stats['total_programs'] . "</p>";
    
} catch (Exception $e) {
    echo $is_cli ? "Error: " . $e->getMessage() . "\n" : '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}

if (!$is_cli) {
    ?>
        </div>
    </body>
    </html>
    <?php
}
?>
