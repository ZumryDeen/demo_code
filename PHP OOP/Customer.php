<?php

/**
 * @name        Zumry
 * @copyright   
 * @version    	1
 * @author     	Zumry Deen
 *      
 *             zumrydeen.prs@gmail.com
 * {
 */
class Customer extends Core_Database {

	//news propoerties
	public $id;
	public $title;
	public $firstName;
	public $lastName;
	public $email;
	public $password;
	public $status;
	public $addedDate;
	public $lastLoginDate;
	public $lastLoginFrom;
	public $searchStr;


	public $error = array();
	public $data_array = array();




	//constructor

	public function Customer() {
		try {
			parent::connect();
		} catch (Exception $exc) {
			throw new PlusProException("Error Connecting to the Database <br/>
					" . $exc->file . "<br/>" . $exc->line);
		}
	}

	public function addCustomer() {
		$recordId = null;
		try {
			$id 			= $this->id;
			$title                  = $this->title;
			$firstName 		= $this->firstName;
			$lastName  		= $this->lastName;
			$email     		= $this->email;
			$password  		= $this->password;
			$status    		= $this->status;
			$addedDate              = $this->addedDate;
			$lastLoginDate          = $this->lastLoginDate;
			$lastLoginFrom          = $this->lastLoginFrom;

			$inserted = $this->insert($this->tb_name, array($id,$title,$firstName,$lastName,$email,$password,$status,$addedDate,$lastLoginDate,$lastLoginFrom));
			if ($inserted) {
				$recordId = $this->getLastInsertedId();
			}
			return $recordId;
		} catch (Exception $e) {
			echo $e->message;
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   editCustomer
	 * @param        :   CustomerObject
	 * @desc   		 :   The function is to edit a page details
	 * @return       :   boolean
	 * Added By      :   Zumry Deen
	 * Added On      :   28-08-2012
	 * Modified By   :   -
	 * Modified On   :   -
	 */

	public function editCustomer() {
		$isUpdated = false;
		try {

			$id 			= $this->id;
			$title                  = $this->title;
			$firstName 		= $this->firstName;
			$lastName  		= $this->lastName;
			$email     		= $this->email;
			$password  		= $this->password;
			$status    		= $this->status;
			$addedDate              = $this->addedDate;
			$lastLoginDate          = $this->lastLoginDate;
			$lastLoginFrom          = $this->lastLoginFrom;

			if($password){
					
				$arrayData = array(
						'id' => $id,
						'title' => $title,
						'firstName' => $firstName,
						'lastName' => $lastName,
						'email' => $email,
						'password' => $password
				);
					
			} else {
					
				$arrayData = array(
						'id' => $id,
						'title' => $title,
						'firstName' => $firstName,
						'lastName' => $lastName,
						'email' => $email
				);
			}
			 
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");
			$isUpdated = $this->update($this->tb_name, $arrayData, $arrWhere);
			return $isUpdated;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}


	/**'
	 * @name         :   updateStatus
	* @param        :   CustomerObject
	* @desc   :   The function is to edit a Customer Status
	* @return       :   boolean
	* Added By      :   Zumry Deen
	* Added On      :   04-09-2012
	* Modified By   :   Zumry Deen
	* Modified On   :   04-09-2012
	*/
	public function updateStatus(){
		$isUpdated = false;
		try{
				
			$id 				= $this->id;
			$status 			= $this->status;
			$arrayData          = array('status'=>$status);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere  = array("id = '" . $id . "'");

			$isUpdated = $this->update($this->tb_name,$arrayData,$arrWhere);
				
			return $isUpdated;
		}catch (Exception $e){
		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>".$e->getMessage()."</em>");
	}





	/**'
	 * @name         :   updatePassword
	* @param        :   CustomerObject
	* @desc         :   The function is to edit a Customer password forgotten
	* @return       :   boolean
	* Added By      :   M. Zumry
	* Added On      :   02-01-2013
	* Modified By   :
	* Modified On   :
	*/
	public function updatePassword(){
		$isUpdated = false;
		try{

			//$id 			= $this->id;
			$email     		= $this->email;
			$password  		= $this->password;
			$arrayData      = array('password'=>$password);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere  = array("email = '" . $email . "'");

			$isUpdated = $this->update($this->tb_name,$arrayData,$arrWhere);

			return $isUpdated;
		}catch (Exception $e){
		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>".$e->getMessage()."</em>");
	}

	/** '
	 * @name         :   deleteCustomer
	 * @param        :   CustomerObject
	 * @desc   :   The function is to delete news details
	 * @return       :   boolean
	 * Added By      :   Zumry Deen
	 * Added On      :   28-08-2012
	 * Modified By   :   -
	 * Modified On   :   -
	 */

	public function deleteCustomer() {
		$isDeleted = false;
		try {
			$id = $this->id;
			$arrWhere = array("id = '" . $id . "'");
			$isDeleted = $this->delete('tbl_customer', $arrWhere);

			return $isDeleted;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   getCustomer
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Customer details
	 * @return       :   Customer Object
	 * Added By      :   Zumry Deen
	 * Added On      :   28-08-2012
	 * Modified By   :   -
	 * Modified On   :   -
	 */

	public function getCustomer($id) {
		$objCustomer = new stdClass();
		$insAddress = new Address();
		try {
			if ($this->connect()) {
				$colums = '*';
				$where = 'id = ' . $id;
				$this->select($this->tb_name, $colums, $where);
				$customerInfo = $this->getResult();


				$objCustomer->id = $customerInfo['id'];
				$objCustomer->title = $customerInfo['title'];
				$objCustomer->firstName = $customerInfo['firstName'];
				$objCustomer->lastName = $customerInfo['lastName'];
				$objCustomer->email = $customerInfo['email'];
				$objCustomer->password = $customerInfo['password'];
				$objCustomer->status = $customerInfo['status'];
				$objCustomer->addedDate  =  $customerInfo['addedDate'];
				$objCustomer->lastLoginDate = $customerInfo['last_login_date'];
				$objCustomer->lastLoginFrom = $customerInfo['last_login_from'];
				 
				 
				//get customer address details
				$objCustomer->addressBillingDtls = $insAddress->getAllByMember($id,'BILLING');
				$objCustomer->addressShippingDtls = $insAddress->getAllByMember($id,'SHIPPING');

			}
			return $objCustomer;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   getAll
	 * @param        :
	 * @desc   :   The function is to get all news details
	 * @return       :   Array (Array Of Page Object)
	 * Added By      :   Zumry Deen
	 * Added On      :   28-08-2012
	 * Modified By   :   -
	 * Modified On   :   -
	 */

	public function getAll() {
		$arrCustomer = array();
		try {
			if ($this->connect()) {
				$colums = 'id';
				$where = '';
				$orderBy = " addedDate Asc";
				$this->select($this->tb_name, $colums, $where, $orderBy);
				$customerResult = $this->getResult();
				foreach ($customerResult As $customerRow) {
					$customerId = $customerRow['id'];
					$customerInfo = $this->getCustomer($customerId);
					array_push($arrCustomer, $customerInfo);
				}
			}

			return $arrCustomer;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}



	/** '
	 * @name         :   countRec
	 * @param        :		Restaurant Menu
	 * @desc         :   The function is to count the Customer details
	 * @return       :   Integer (Total number Of Customer)
	 * Added By      :   Zumry Deen
	 * Added On      :   22-08-2012
	 * Modified By   :   Zumry Deen
	 * Modified On   :   04-09-2012
	 */

	public function countRec() {
		$totalNumberOfRec = 0;
		$arrWhere = array();
		try {
			$SQL = "SELECT * FROM $this->tb_name ";
			if ($this->searchStr != '') {
				array_push($arrWhere, "firstName LIKE '" . "%" . $this->searchStr . "%" . "'");
			}

			if (count($arrWhere) > 0)
				$SQL.= "WHERE " . implode(' AND ', $arrWhere);


			$dbResult = $this->executeSelectQuery($SQL);
			$newsRes = $this->getResult();
			$totalNumberOfRec = count($newsRes);
			return $totalNumberOfRec;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   search
	 * @param        :
	 * Description   :   The function is to search  Restaurant Menu details
	 * @return       :   Array (Array Of RestaurantMenu Object)
	 * Added By      :   Zumry Deen
	 * Added On      :   22-08-2012
	 * Modified By   :   Zumry Deen
	 * Modified On   :   22-08-2012
	 */

	public function search() {
		$arrCustomer = array();
		$arrWhere = array();
		try {
			$SQL = "SELECT * FROM $this->tb_name ";
			if ($this->searchStr != '') {
				array_push($arrWhere, "firstName LIKE '" . "%" . $this->searchStr . "%" . "'");
			}

			if ($this->searchStrEmail != '') {
				array_push($arrWhere, "email= '". $this->searchStrEmail . "'");
			}

			if (count($arrWhere) > 0)
				$SQL.= "WHERE " . implode(' AND ', $arrWhere);


			 

			if ($this->limit) {
				$SQL.= $this->limit;
			}
			//echo $SQL;
			$dbResult = $this->executeSelectQuery($SQL);
			$newsRes = $this->getResult();
			foreach ($newsRes As $newsRow) {
				$newsId = $newsRow['id'];
				$newsInfo = $this->getCustomer($newsId);
				array_push($arrCustomer, $newsInfo);
			}
			return $arrCustomer;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}



	/**'
	 * @name         :   loginCustomer
	* @param        :   Integer (User ID)
	* Description   :   The function is to authenticate customers
	* @return       :   Customer Object
	* Added By      :   Zumry Deen
	* Added On      :   16-08-2012
	* Modified By   :   Zumry Deen
	* Modified On   :   16-08-2012
	*/
	public function loginCustomer($username,$password){
		$objCustomer = new stdClass();
		try{
			$colums = '*';
			$where  = "email = '".$username."' AND password = '".$password."'";
			$this->select($this->tb_name,$colums,$where);
			$customerInfo = $this->getResult();
			if($customerInfo){
				$objCustomer->id = $customerInfo['id'];
				$objCustomer->title = $customerInfo['title'];
				$objCustomer->firstName = $customerInfo['firstName'];
				$objCustomer->lastName = $customerInfo['lastName'];
				$objCustomer->email = $customerInfo['email'];
				$objCustomer->status = $customerInfo['status']; // status
				$objCustomer->addedDate = $customerInfo['addedDate'];
				$objCustomer->lastLoginDate = $customerInfo['lastLoginDate'];
				$objCustomer->lastLoginFrom = $customerInfo['lastLoginFrom'];
			} else {
				return null;
			}
			return $objCustomer;
		}catch (Exception $e){
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>User</em>, <strong>Function -</strong> <em>getUser()</em>, <strong>Exception -</strong> <em>".$e->getMessage()."</em>");
		}

	}
	 
}
?>