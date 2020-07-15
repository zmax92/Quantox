<?php
namespace App;

class QueryStudent {
    
    /**
     * Function Queries database for student id
     */
    public function findStudent(int $id) {
        $db = new \SQLite3('db/database.db');

        $statement = $db->prepare('Select s.ID as id, s.Name as name, s.Board as board, group_concat(g.Grade, \', \') as grades
            from students s
            left join grades g on g.Student = s.ID
            where s.id = :id;');
        $statement->bindValue(':id', $id);

        $result = $statement->execute();

        if(!empty($result)) {
            $info_array = $result->fetchArray();

            $prepared_data = $this->prepareData($info_array);

            return $prepared_data;
        }
        else{
            return 'No sudent found under ID: '.$id;
        }
    }

    /**
     * Function structures query results
     */
    private function prepareData(array $data) {
        $structure = [
            'ID' => $data['id'],
            'Name' => $data['name'],
            'Grades' => $data['grades']
        ];

        $grades = explode(',', $data['grades']);
        $structure['Avarage grade'] = array_sum($grades) / count($grades);

        $fail_pass = $this->failPass($grades, $data['board']);
        $structure = array_merge($structure, $fail_pass);

        return $structure;
    }

    /**
     * Function determents fail/pass for final result
     */
    private function failPass(array $grades, string $board) {
        switch ($board) {
            case 'CSM':
                $final_result = (array_sum($grades) / count($grades)) >= 7 ? 'Pass' : 'Fail';

                return array(
                    'Final result' => $final_result,
                    'Format' => 'json'
                );
                break;
            case 'CSMB':
                $final_result = 'Fail';

                if(count($grades) > 2 && max($grades) > 8) {
                    $final_result = 'Pass';
                }
                return array(
                    'Final result' => $final_result,
                    'Format' => 'xml'
                );
                break;
        }

    }
}