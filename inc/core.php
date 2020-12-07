<?php
// Be sure to input YOUR database details below
// Watch the associated videos here: https://www.youtube.com/playlist?list=PLLs69n7Q4dCx5_7ZwnxTymH8X0iRP_2vw

require 'config.php';

if ( !class_exists( 'DB' ) ) {
	class DB {
		public function connectDatabase() {
			return new mysqli(HOST, DBUSER, DBPWD, DATABASE);
		}
		public function query($query) {
			$conn = $this->connectDatabase();
			$result = $conn->query($query);
			
			while ( $row = $result->fetch_object() ) {
				$results[] = $row;
			}
			
			return $results;
        }
        public function insert($table, $data, $format) {
			// Check for $table or $data not set
			if ( empty( $table ) || empty( $data ) ) {
				return false;
			}
			
			// Connect to the database
			$conn = $this->connectDatabase();
			
			// Cast $data and $format to arrays
			$data = (array) $data;
			$format = (array) $format;
			
			// Build format string
			$format = implode('', $format); 
			$format = str_replace('%', '', $format);
			
			list( $fields, $placeholders, $values ) = $this->prep_query($data);
			
			// Prepend $format onto $values
			array_unshift($values, $format); 

			// Prepary our query for binding
			$stmt = $conn->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");

			// Dynamically bind values
			call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($values));
			
			// Execute the query
			$stmt->execute();
			
			// Check for successful insertion
			if ( $stmt->affected_rows ) {
				return true;
			}
			
			return false;
		}
	}
}
$DB = new DB;

print_r($db->insert('education', array('EducationID'=>'2', 'post_content' => 'Abstraction test content'), array('%s', '%s')));
