<?php
namespace App;

class QueryStudent {
    
    /**
     * Function Queries database for student id
     */
    public function findStudent(int $id) {
        $db = new \SQLite3('db/database.db');

        $statement = $db->prepare('Select s.ID as id, s.Name as name, group_concat(g.Grade) as grades
            from students s
            left join grades g on g.Student = s.ID
            where s.id = :id;');
        $statement->bindValue(':id', $id);

        $result = $statement->execute();

        if(!empty($result)) {
            return $result->fetchArray();
        }
        else{
            return FALSE;
        }
    }
}