<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MigrateDb extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $sql = file_get_contents(ROOTPATH . 'database/migration_penerbangan.sql');
        
        $queries = explode(';', $sql);
        
        $success = 0;
        $failed = 0;
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    $db->query($query);
                    $success++;
                } catch (\Exception $e) {
                    echo "Error on query: $query <br> Error: " . $e->getMessage() . "<br><br>";
                    $failed++;
                }
            }
        }
        
        echo "Migration complete! Success: $success, Failed: $failed";
    }
}
