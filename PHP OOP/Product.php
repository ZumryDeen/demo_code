<?php
/**
 * @name        Zumry 
 * @copyright   Zumry 
 * @license     
 * @version    	1
 * @author     	zumry Deen
 *             
 *              zumrydeen.prs@gmail.com
 * @modified on : 2014-11-01 <zumrydeen.prs@gmail.com>
 * @desc        : two database columns added for product weight unit and product weight based on that base product class modifications
 */

class Product extends Core_Database {
	//product propoerties
	public $id;
	public $productName;
	public $productSmallDescription;
	public $unitPrice;
	public $discountPrice;
	public $priceCurrency;
	public $weightUnit;
	public $productWeight;
	public $stockInHand;
	public $reorderLevel;
	public $category;
	public $addedOn;
	public $addedBy;
	public $status;
	public $isFeatured;
	public $productDescription;
	public $keywords;
	public $displayOrder;
	public $productCode;
	public $listParam;
	public $searchStr;
	public $listingOrder;
	public $limit;
	public $categoryGroup;
	public $productImages;
	public $productDefaultImage;
	public $error = array();
	public $data_array = array();
	public $isSpecialOffer;
	public $productBrand;
	public $productSize;
	public $typeId;
	public $photo;
	public $ProductsubCategory;

	public $minprice;
	public $maxprice;


	public $tags;
	public $colourSwatch;
	public $furtherInformation;
	public $relatedProducts;

	public $m_products_productsID;
	public $footNote;
	public $priceGuide;

	//custom added fileds

	public $retail_rr_yes_no;
	public $retail_rr_text;
	public $special_order;
	public $yoo_exclusive;
	public $default_image;
	public $img2;
	public $img3;
	public $img4;
	public $img_line_drawing;
	public $img_line_drawing_2;
	public $img_line_drawing_3;
	public $img_line_drawing_4;
	public $delivery_time;
	public $delivery_returns;
	public $dimensions_w;
	public $dimensions_d;
	public $dimensions_h;
	public $secondary_dimensions;
	public $material_text;
	public $material_text_2;
	public $material_text_3;

	public $second_main_material_text_1;
	public $second_main_material_text_2;
	public $second_main_material_text_3;

	public $second_sub_material_text_1;
	public $second_sub_material_text_2;
	public $second_sub_material_text_3;

	public $material_text_4;
	public $material_text_5;
	public $material_text_6;

	public $material_text_heading;
	public $material_text_heading_2;
	public $material_text_heading_3;

	public $second_main_material_text_heading_1;
	public $second_main_material_text_heading_2;
	public $second_main_material_text_heading_3;

	public $second_sub_material_text_heading_1;
	public $second_sub_material_text_heading_2;
	public $second_sub_material_text_heading_3;

	public $material_text_heading_4;
	public $material_text_heading_5;
	public $material_text_heading_6;

	public $sku_swatch;

	public $colour;
	public $web_colours;
	public $tbl_designer_id;





	//constructor



	public function Product() {
		try {
			parent::connect();
		} catch (Exception $exc) {
			throw new PlusProException("Error Connecting to the Database <br/>
					" . $exc->file . "<br/>" . $exc->line);
		}
	}



	/** '
	 * @name         :   getallprodutID
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */



	public function getProID($catID) {
		$data_array = array();
		try {
			if ($this->connect()) {
				$SQL = "SELECT id  FROM tbl_product ";
				$SQL.= " WHERE FIND_IN_SET( $catID, `tbl_category_id`)";
				$this->executeSelectQuery($SQL);
				$fieldsResult = $this->getResult();
				foreach ($fieldsResult As $fieldRow) {
					$fieldId = $fieldRow['id'];
					array_push($data_array,$fieldId);
				}
			}
			return $data_array;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   getProduct
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */


	public function getAllprice() {
		$data_array = array();
		try {
			if ($this->connect()) {


				$SQL = "SELECT id,tbl_category_id FROM tbl_product";
				$this->executeSelectQuery($SQL);
				$fieldsResult = $this->getResult();
				foreach ($fieldsResult As $fieldRow) {
					$fieldId = $fieldRow['m_products_productsID'];
					$fieldInfo = $this->getoldb($fieldId);
					array_push($data_array,$fieldInfo);
				}
			}

			return $data_array;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}




	/** '
	 * @name         :   getProduct
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */
	public function getoldb($productId) {
		$objProduct = new stdClass();
		try {
			if ($this->connect()) {
				$colums = '*';
				$where = 'm_products_productsID = ' . $productId;
				$this->select('m_products_products', $colums, $where);
				$productInfo = $this->getResult();

				$objProduct->m_products_productsID = $productInfo['m_products_productsID'];
				$objProduct->footNote = $productInfo['footNote'];

			}
			return $objProduct;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}


	/** '
	 * @name         :   getProduct
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */


	public function addpriceGuide() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$priceGuide = $this->priceGuide;

			$arrayData = array(
					'priceGuide' => $priceGuide
			);


			$arrWhere = array("id = '" . $id . "'");
			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);
			return $isUpdated;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}





	/** '
	 * @name         :   editProduct
	 * @param        :   ProductObject
	 * @desc   :   The function is to edit a page details
	 * @return       :   boolean
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :  2014-11-01
	 */
	public function addProduct() {
		 
		 
		$recordId = null;
		try {
			$id = $this->id;
			$productName = $this->productName;
			$productSmallDescription = $this->productSmallDescription;
			$unitPrice = $this->unitPrice;
			$discountPrice = $this->discountPrice;
			$priceCurrency = $this->priceCurrency;
			$weightUnit = $this->weightUnit;
			$productWeight = $this->productWeight;
			$stockInHand = $this->stockInHand;
			$reorderLevel = $this->reorderLevel;
			$category = $this->category;
			$addedOn = $this->addedOn;
			$addedBy = $this->addedBy;
			$status = $this->status;
			$isFeatured = $this->isFeatured;
			$productDescription = $this->productDescription;
			$keywords = $this->keywords;
			$displayOrder = $this->displayOrder;
			$productCode = $this->productCode;
			$isSpecialOffer = $this->isSpecialOffer;
			$productBrand = $this->productBrand;
			$productSize = $this->productSize;
			$typeId = $this->typeId;
			$ProductsubCategory = $this->ProductsubCategory;
			$photo = $this->photo;

			$tags = $this->tags;
			$colourSwatch = $this->colourSwatch;
			$furtherInformation= $this->furtherInformation;
			$priceGuide= $this->priceGuide;

			 
			$retail_rr_yes_no = $this->retail_rr_yes_no;
			$retail_rr_text   = $this->retail_rr_text;
			$special_order    = $this->special_order;
			$yoo_exclusive    = $this->yoo_exclusive;
			$default_image    = $this->default_image;
			$img2             = $this->img2;
			$img3             = $this->img3;
			$img4             = $this->img4;
			$img_line_drawing = $this->img_line_drawing;
			$img_line_drawing_2         = $this->img_line_drawing_2;
			$img_line_drawing_3         = $this->img_line_drawing_3;
			$img_line_drawing_4         = $this->img_line_drawing_4;
			$delivery_time    = $this->delivery_time;
			$delivery_returns = $this->delivery_returns;
			$dimensions_w     = $this->dimensions_w;
			$dimensions_d     = $this->dimensions_d;
			$dimensions_h     = $this->dimensions_h;
			$secondary_dimensions = $this->secondary_dimensions;
			$material_text        = $this->material_text;
			$material_text_2      = $this->material_text_2;
			$material_text_3      = $this->material_text_3;
			 
			 
			$second_main_material_text_1      = $this->second_main_material_text_1;
			$second_main_material_text_2      = $this->second_main_material_text_2;
			$second_main_material_text_3      = $this->second_main_material_text_3;
			 
			 
			$second_sub_material_text_1      = $this->second_sub_material_text_1;
			$second_sub_material_text_2      = $this->second_sub_material_text_2;
			$second_sub_material_text_3      = $this->second_sub_material_text_3;
			 
			$material_text_4      = $this->material_text_4;
			$material_text_5      = $this->material_text_5;
			$material_text_6      = $this->material_text_6;
			 
			$material_text_heading   = $this->material_text_heading;
			$material_text_heading_2 = $this->material_text_heading_2;
			$material_text_heading_3 = $this->material_text_heading_3;
			 
			$second_main_material_text_heading_1 = $this->second_main_material_text_heading_1;
			$second_main_material_text_heading_2 = $this->second_main_material_text_heading_2;
			$second_main_material_text_heading_3 = $this->second_main_material_text_heading_3;
			 
			$second_sub_material_text_heading_1      = $this->second_sub_material_text_heading_1;
			$second_sub_material_text_heading_2      = $this->second_sub_material_text_heading_2;
			$second_sub_material_text_heading_3      = $this->second_sub_material_text_heading_3;
			 
			$material_text_heading_4 = $this->material_text_heading_4;
			$material_text_heading_5 = $this->material_text_heading_5;
			$material_text_heading_6 = $this->material_text_heading_6;
			 
			 
			$sku_swatch              = $this->sku_swatch;
			 
			$colour               = $this->colour;
			$web_colours          = $this->web_colours;
			$tbl_designer_id      = $this->tbl_designer_id;



			$inserted = $this->insert('tbl_product', array($id, $productName, $productSmallDescription, $unitPrice, $discountPrice, $priceCurrency, $weightUnit, $productWeight, $stockInHand, $reorderLevel, $category,$ProductsubCategory, $addedOn, $addedBy, $status, $isFeatured, $productDescription, $keywords, $displayOrder, $productCode, $isSpecialOffer, $productBrand,$productSize,'',$typeId,$photo,'',$colourSwatch,$furtherInformation,$priceGuide,
					$retail_rr_yes_no,$retail_rr_text,$special_order,$yoo_exclusive,$default_image,$img2,$img3,$img4,$img_line_drawing,$img_line_drawing_2,$img_line_drawing_3,$img_line_drawing_4,
					$delivery_time,$delivery_returns,$dimensions_w,$dimensions_d,$dimensions_h,$secondary_dimensions,$material_text,
					$material_text_2,$material_text_3,$second_main_material_text_1,$second_main_material_text_2,$second_main_material_text_3,$second_sub_material_text_1,$second_sub_material_text_2,$second_sub_material_text_3,
					$material_text_4,$material_text_5,$material_text_6,$material_text_heading,$material_text_heading_2,$material_text_heading_3,$second_main_material_text_heading_1,$second_main_material_text_heading_2,$second_main_material_text_heading_3,
					$second_sub_material_text_heading_1,$second_sub_material_text_heading_2,$second_sub_material_text_heading_3,$material_text_heading_4,$material_text_heading_5,$material_text_heading_6,$sku_swatch,$colour,$web_colours,$tbl_designer_id
			));
			if ($inserted) {
				$recordId = $this->getLastInsertedId();
			}
			return $recordId;
		} catch (Exception $e) {
			echo $e->message;
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}



	public function editProductCat() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$category = $this->category;



			$arrayData = array(
					//'id' => $id,
					'tbl_category_id' => $category
			);


			$arrWhere = array("id = '" . $id . "'");
			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);
			return $isUpdated;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}








	public function editProduct() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$productName = $this->productName;
			$productSmallDescription = $this->productSmallDescription;
			$unitPrice = $this->unitPrice;
			$discountPrice = $this->discountPrice;
			$priceCurrency = $this->priceCurrency;
			$weightUnit = $this->weightUnit;
			$productWeight = $this->productWeight;
			$stockInHand = $this->stockInHand;
			$reorderLevel = $this->reorderLevel;
			$category = $this->category;
			$addedOn = $this->addedOn;
			$addedBy = $this->addedBy;
			$status = $this->status;
			$isFeatured = $this->isFeatured;
			$productDescription = $this->productDescription;
			$keywords = $this->keywords;
			$displayOrder = $this->displayOrder;
			$productCode = $this->productCode;
			$isSpecialOffer = $this->isSpecialOffer;
			$productBrand = $this->productBrand;
			$productSize = $this->productSize;
			$typeId = $this->typeId;
			$ProductsubCategory = $this->ProductsubCategory;
			$photo = $this->photo;

			$tags = $this->tags;
			$colourSwatch = $this->colourSwatch;
			$furtherInformation= $this->furtherInformation;
			$relatedProducts= $this->relatedProducts;
			$priceGuide = $this->priceGuide;

			//added fileds custom

			$retail_rr_yes_no = $this->retail_rr_yes_no;
			$retail_rr_text   = $this->retail_rr_text;
			$special_order    = $this->special_order;
			$yoo_exclusive    = $this->yoo_exclusive;
			$default_image    = $this->default_image;
			$img2             = $this->img2;
			$img3             = $this->img3;
			$img4             = $this->img4;
			$img_line_drawing = $this->img_line_drawing;
			$img_line_drawing_2         = $this->img_line_drawing_2;
			$img_line_drawing_3         = $this->img_line_drawing_3;
			$img_line_drawing_4         = $this->img_line_drawing_4;
			$delivery_time    = $this->delivery_time;
			$delivery_returns = $this->delivery_returns;
			$dimensions_w     = $this->dimensions_w;
			$dimensions_d     = $this->dimensions_d;
			$dimensions_h     = $this->dimensions_h;
			$secondary_dimensions = $this->secondary_dimensions;

			 

			$material_text        = $this->material_text;
			$material_text_2      = $this->material_text_2;
			$material_text_3      = $this->material_text_3;

			$second_main_material_text_1      = $this->second_main_material_text_1;
			$second_main_material_text_2      = $this->second_main_material_text_2;
			$second_main_material_text_3      = $this->second_main_material_text_3;

			$second_sub_material_text_1      = $this->second_sub_material_text_1;
			$second_sub_material_text_2      = $this->second_sub_material_text_2;
			$second_sub_material_text_3      = $this->second_sub_material_text_3;


			$material_text_4      = $this->material_text_4;
			$material_text_5      = $this->material_text_5;
			$material_text_6      = $this->material_text_6;

			$material_text_heading   = $this->material_text_heading;
			$material_text_heading_2 = $this->material_text_heading_2;
			$material_text_heading_3 = $this->material_text_heading_3;

			$second_main_material_text_heading_1 = $this->second_main_material_text_heading_1;
			$second_main_material_text_heading_2 = $this->second_main_material_text_heading_2;
			$second_main_material_text_heading_3 = $this->second_main_material_text_heading_3;

			$second_sub_material_text_heading_1      = $this->second_sub_material_text_heading_1;
			$second_sub_material_text_heading_2      = $this->second_sub_material_text_heading_2;
			$second_sub_material_text_heading_3      = $this->second_sub_material_text_heading_3;

			$material_text_heading_4 = $this->material_text_heading_4;
			$material_text_heading_5 = $this->material_text_heading_5;
			$material_text_heading_6 = $this->material_text_heading_6;

			$sku_swatch           = $this->sku_swatch;
			 
			$colour               = $this->colour;
			$web_colours          = $this->web_colours;
			$tbl_designer_id          = $this->tbl_designer_id;


			$arrayData = array(
					'id' => $id,
					'product_name' => $productName,
					'product_small_description' => $productSmallDescription,

					'unit_price' => $unitPrice,
					'discount_price' => $discountPrice,
					//  'price_currency' => $priceCurrency,
					'weight_unit' => $weightUnit,
					// 'product_weight' => $productWeight,
					'stock_in_hand' => $stockInHand,
					'reorder_level' => $reorderLevel,
					// 'tbl_category_id' => $category,
					'tbl_sub_category_id' => $ProductsubCategory,
					'added_on' => $addedOn,
					'added_by' => $addedBy,
					'status' => $status,
					'is_featured' => $isFeatured,
					'product_description' => $productDescription,
					'keywords' => $keywords,
					'display_order' => $displayOrder,
					'product_code' => $productCode,
					'is_special_offers' => $isSpecialOffer,
					'product_brand' => $productBrand,
					'product_size' => $productSize,
					'furtherInformation' => $furtherInformation,
					'priceGuide' => $priceGuide,
					'typeId' => $typeId,
					'photo' => $photo,


					//'tags' => $tags,
					'colourSwatch' => $colourSwatch,
					//'furtherInformation' => $furtherInformation,
					//'relatedProducts' => $relatedProducts

					'retail_rr_yes_no' => $retail_rr_yes_no,
					'retail_rr_text'   => $retail_rr_text,
					'special_order'    => $special_order,
					'yoo_exclusive'    => $yoo_exclusive,
					'default_image'    => $default_image,
					'img2'             => $img2,
					'img3'             => $img3,
					'img4'             => $img4,
					'img_line_drawing' => $img_line_drawing,
					'img_line_drawing_2' => $img_line_drawing_2,
					'img_line_drawing_3' => $img_line_drawing_3,
					'img_line_drawing_4' => $img_line_drawing_4,

					'delivery_time'    => $delivery_time,
					'delivery_returns' => $delivery_returns,
					'dimensions_w'     => $dimensions_w,
					'dimensions_d'     => $dimensions_d,
					'dimensions_h'     => $dimensions_h,
					'secondary_dimensions' => $secondary_dimensions,
					'material_text'        => $material_text,
					'material_text_2'      => $material_text_2,
					'material_text_3'      => $material_text_3,

					'second_main_material_text_1'  => $second_main_material_text_1,
					'second_main_material_text_2'  => $second_main_material_text_2,
					'second_main_material_text_3'  => $second_main_material_text_3,


					'second_sub_material_text_1'  => $second_sub_material_text_1,
					'second_sub_material_text_2'  => $second_sub_material_text_2,
					'second_sub_material_text_3'  => $second_sub_material_text_3,


					'material_text_4'      => $material_text_4,
					'material_text_5'      => $material_text_5,
					'material_text_6'      => $material_text_6,

					'material_text_heading'   => $material_text_heading,
					'material_text_heading_2' => $material_text_heading_2,
					'material_text_heading_3' => $material_text_heading_3,

					'second_main_material_text_heading_1' => $second_main_material_text_heading_1,
					'second_main_material_text_heading_2' => $second_main_material_text_heading_2,
					'second_main_material_text_heading_3' => $second_main_material_text_heading_3,

					'second_sub_material_text_heading_1' => $second_sub_material_text_heading_1,
					'second_sub_material_text_heading_2' => $second_sub_material_text_heading_2,
					'second_sub_material_text_heading_3' => $second_sub_material_text_heading_3,

					'material_text_heading_4' => $material_text_heading_4,
					'material_text_heading_5' => $material_text_heading_5,
					'material_text_heading_6' => $material_text_heading_6,
					 

					'sku_swatch'           => $sku_swatch,

					'colour'               => $colour,
					'web_colours'          => $web_colours,
					'tbl_designer_id'          => $tbl_designer_id

			);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");
			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);
			return $isUpdated;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/*     * '
	 * @name         :   updateOrder
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function updateOrder() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$displayOrder = $this->displayOrder;
			$arrayData = array('display_order' => $displayOrder);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}

	/** '
	 * @name         :   getProdutIdS - Search
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */



	public function getProIDSRH($searchQ) {
		$data_array = array();
		try {
			if ($this->connect()) {


				$SQL = "SELECT id  FROM tbl_product ";
				//$SQL.= " WHERE category = 7";
				$SQL.= "where product_name LIKE '" . "%" . $this->searchStr . "%" . "'";
				//echo $SQL;
				//$SQL.= ' ORDER BY id ASC';

				//echo $SQL;
				$this->executeSelectQuery($SQL);
				//exit();



				$fieldsResult = $this->getResult();
				foreach ($fieldsResult As $fieldRow) {
					$fieldId = $fieldRow['id'];
					array_push($data_array,$fieldId);
				}
			}

			return $data_array;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}





	/*     * '
	 * @name         :   remove Comma - Only for Developing not to use
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function removecomma() {
		$isUpdated = false;
		 
		 
		try {

			$id = $this->id;
			$category = $this->$category;
			$arrayData = array('tbl_category_id' => $category);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}




	/*     * '
	 * @name         :   updateOrder
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function updateStock() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$stockInHand = $this->stockInHand;
			$arrayData = array('stock_in_hand' => $stockInHand);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}



	/*     * '
	 * @name         :   updateOrder
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function updateRecordLevel() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$stockInHand = $this->stockInHand;
			$arrayData = array('stock_in_hand' => $stockInHand);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}

	/** '
	 * @name         :   deleteProduct
	 * @param        :   ProductObject
	 * @desc   :   The function is to delete product details
	 * @return       :   boolean
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   -
	 * Modified On   :   -
	 */
	public function deleteProduct() {
		$isDeleted = false;
		try {
			$id = $this->id;
			$arrWhere = array("id = '" . $id . "'");
			$isDeleted = $this->delete('tbl_product', $arrWhere);

			return $isDeleted;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}




	/** '
	 * @name         :   deleteProduct
	 * @param        :   ProductObject
	 * @desc   :   The function is to delete product details
	 * @return       :   boolean
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   -
	 * Modified On   :   -
	 */
	public function deleteProductByCategoryId() {
		$isDeleted = false;
		try {
			$id = $this->category;
			$arrWhere = array("tbl_category_id = '" . $id . "'");
			$isDeleted = $this->delete('tbl_product', $arrWhere);

			return $isDeleted;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   deleteProduct
	 * @param        :   ProductObject
	 * @desc   :   The function is to delete product details
	 * @return       :   boolean
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   -
	 * Modified On   :   -
	 */
	public function deleteProductBysubCategoryId() {
		$isDeleted = false;
		try {
			$id = $this->ProductsubCategory;
			$arrWhere = array("tbl_sub_category_id = '" . $id . "'");
			$isDeleted = $this->delete('tbl_product', $arrWhere);

			return $isDeleted;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}


	/** '
	 * @name         :   deleteProduct
	 * @param        :   ProductObject
	 * @desc   :   The function is to delete product details
	 * @return       :   boolean
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   -
	 * Modified On   :   -
	 */
	public function deleteProductBybrandId() {
		$isDeleted = false;
		try {
			$id = $this->productBrand;
			$arrWhere = array("product_brand = '" . $id . "'");
			$isDeleted = $this->delete('tbl_product', $arrWhere);

			return $isDeleted;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>addPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   getProduct
	 * @param        :   Integer (Page ID)
	 * @desc   :   The function is to get a Product details
	 * @return       :   Product Object
	 * Added By      :   zumry Deen
	 * Added On      :   28-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   2014-11-01
	 */
	public function getProduct($productId) {
		$objProduct = new stdClass();
		$objProductImage = new Image();
		$objCurrency = new Currency();
		$objCategory = new Category();
		$objBrand = new Brand();
		//$objSize = new ObjectSizeMap();

		try {
			if ($this->connect()) {
				$colums = '*';
				$where = 'id = ' . $productId;
				$this->select('tbl_product', $colums, $where);
				$productInfo = $this->getResult();

				//echo "<pre>".print_r($productInfo)."</pre>";

				$objProduct->id = $productInfo['id'];
				$objProduct->productName = $productInfo['product_name'];
				$objProduct->category = $productInfo['tbl_category_id'];
				$objProduct->productSmallDescription = $productInfo['product_small_description'];
				$objProduct->unitPrice = $productInfo['unit_price'];
				$objProduct->discountPrice = $productInfo['discount_price'];

				//  $currencyInfo = $objCurrency->getCurrency($productInfo['price_currency']);

				//  if ($currencyInfo) {
				//      $objProduct->priceCurrency = $currencyInfo;
				//  }
				$objProduct->weightUnit = $productInfo['weight_unit'];
				$objProduct->productWeight = $productInfo['product_weight'];
				$objProduct->stockInHand = $productInfo['stock_in_hand'];
				$objProduct->reorderLevel = $productInfo['reorder_level'];

				$objProduct->addedOn = $productInfo['added_on'];
				$objProduct->addedBy = $productInfo['added_by'];
				$objProduct->status = $productInfo['status'];
				$objProduct->isFeatured = $productInfo['is_featured'];
				$objProduct->productDescription = $productInfo['product_description'];
				$objProduct->keywords = $productInfo['keywords'];
				$objProduct->displayOrder = $productInfo['display_order'];
				$objProduct->isSpecialOffer = $productInfo['is_special_offers'];
				$objProduct->typeId =  $productInfo['typeId'];
				$objProduct->photo = $productInfo['photo'];
				$objProduct->ProductsubCategory = $productInfo['tbl_sub_category_id'];

				$objProduct->productBrand = $productInfo['product_brand'];
				$objProduct->productSize = $productInfo['product_size'];

				$objProduct->colourSwatch = $productInfo['colourSwatch'];
				$objProduct->furtherInformation = $productInfo['furtherInformation'];
				$objProduct->relatedProducts = $productInfo['relatedProducts'];
				$objProduct->tags = $productInfo['tags'];
				$objProduct->priceGuide = $productInfo['priceGuide'];
				 
				$objProduct->retail_rr_yes_no = $productInfo['retail_rr_yes_no'];
				$objProduct->retail_rr_text   = $productInfo['retail_rr_text'];
				$objProduct->special_order    = $productInfo['special_order'];
				$objProduct->yoo_exclusive    = $productInfo['yoo_exclusive'];
				$objProduct->default_image    = $productInfo['default_image'];
				$objProduct->img2             = $productInfo['img2'];
				$objProduct->img3             = $productInfo['img3'];
				$objProduct->img4             = $productInfo['img4'];
				$objProduct->img_line_drawing = $productInfo['img_line_drawing'];
				$objProduct->img_line_drawing_2 = $productInfo['img_line_drawing_2'];
				$objProduct->img_line_drawing_3 = $productInfo['img_line_drawing_3'];
				$objProduct->img_line_drawing_4 = $productInfo['img_line_drawing_4'];

				$objProduct->delivery_time    = $productInfo['delivery_time'];
				$objProduct->delivery_returns = $productInfo['delivery_returns'];
				$objProduct->dimensions_w     = $productInfo['dimensions_w'];
				$objProduct->dimensions_d     = $productInfo['dimensions_d'];
				$objProduct->dimensions_h     = $productInfo['dimensions_h'];
				$objProduct->secondary_dimensions = $productInfo['secondary_dimensions'];


				$objProduct->material_text                 = $productInfo['material_text'];
				$objProduct->material_text_2               = $productInfo['material_text_2'];
				$objProduct->material_text_3               = $productInfo['material_text_3'];



				$objProduct->second_main_material_text_1              = $productInfo['second_main_material_text_1'];
				$objProduct->second_main_material_text_2              = $productInfo['second_main_material_text_2'];
				$objProduct->second_main_material_text_3              = $productInfo['second_main_material_text_3'];

				$objProduct->second_sub_material_text_1              = $productInfo['second_sub_material_text_1'];
				$objProduct->second_sub_material_text_2              = $productInfo['second_sub_material_text_2'];
				$objProduct->second_sub_material_text_3              = $productInfo['second_sub_material_text_3'];


				$objProduct->material_text_4               = $productInfo['material_text_4'];
				$objProduct->material_text_5               = $productInfo['material_text_5'];
				$objProduct->material_text_6               = $productInfo['material_text_6'];


				$objProduct->material_text_heading         = $productInfo['material_text_heading'];
				$objProduct->material_text_heading_2       = $productInfo['material_text_heading_2'];
				$objProduct->material_text_heading_3       = $productInfo['material_text_heading_3'];

				$objProduct->second_main_material_text_heading_1              = $productInfo['second_main_material_text_heading_1'];
				$objProduct->second_main_material_text_heading_2              = $productInfo['second_main_material_text_heading_2'];
				$objProduct->second_main_material_text_heading_3              = $productInfo['second_main_material_text_heading_3'];

				$objProduct->second_sub_material_text_heading_1              = $productInfo['second_sub_material_text_heading_1'];
				$objProduct->second_sub_material_text_heading_2              = $productInfo['second_sub_material_text_heading_2'];
				$objProduct->second_sub_material_text_heading_3              = $productInfo['second_sub_material_text_heading_3'];


				$objProduct->material_text_heading_4       = $productInfo['material_text_heading_4'];
				$objProduct->material_text_heading_5       = $productInfo['material_text_heading_5'];
				$objProduct->material_text_heading_6       = $productInfo['material_text_heading_6'];





				$objProduct->sku_swatch           = $productInfo['sku_swatch'];

				$objProduct->colour               = $productInfo['colour'];
				$objProduct->web_colours          = $productInfo['web_colours'];
				$objProduct->tbl_designer_id      = $productInfo['tbl_designer_id'];
				 




				$productId = $productInfo['id'];
				$defaultImage = "";
				$productImages = $objProductImage->getAllByImageObject('Product', $productId);
				if ($productImages) {
					$defaultImage = $productImages[0];
					$objProduct->productDefaultImage = $defaultImage;
					$objProduct->productImages = $productImages;
				}

				$objProduct->productCode = $productInfo['product_code'];
				 
			}

			return $objProduct;

		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}




	/** '
	 * @name         :   countRec
	 * @param        :   Restaurant Menu
	 * @desc         :   The function is to count the Product details
	 * @return       :   Integer (Total number Of Product)
	 * Added By      :   zumry Deen
	 * Added On      :   22-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   04-09-2014
	 */
	public function Maxprice($catID,$search,$brand,$designerId) {
		$totalNumberOfRec = 0;
		$swatmaxinfo = new stdClass();
		$arrWhere = array();
		try {

			if($catID){
				$SQL = "SELECT MAX(unit_price) AS HighestPrice FROM tbl_product WHERE FIND_IN_SET ($catID,`tbl_category_id`)";
			}

			if($search){
				//array_push($arrWhere, "product_name LIKE '" . "%" . $this->searchStr . "%" . "'");
				///or product_description LIKE '" . "%". $this->productDescription ."%" . "'"
				 
				$SQL = "SELECT MAX(unit_price) AS HighestPrice FROM tbl_product WHERE product_name LIKE '"."%".$search."%"."' or product_description LIKE '"."%".$search."%"."'";
			}

			if($brand){
				//array_push($arrWhere, "product_name LIKE '" . "%" . $this->searchStr . "%" . "'");
				///or product_description LIKE '" . "%". $this->productDescription ."%" . "'"

				$SQL = "SELECT MAX(unit_price) AS HighestPrice FROM tbl_product WHERE status = 'Published' AND product_brand = '$brand'";
			}

			if($designerId){
				//array_push($arrWhere, "product_name LIKE '" . "%" . $this->searchStr . "%" . "'");
				///or product_description LIKE '" . "%". $this->productDescription ."%" . "'"

				$SQL = "SELECT MAX(unit_price) AS HighestPrice FROM tbl_product WHERE status = 'Published' AND tbl_designer_id = '$designerId'";
			}
			//echo "$SQL";
			$dbResult = $this->executeSelectQuery($SQL);
			$swatmaxinfo = $this->getResult();

			//print_r($swatmaxinfo);

			return $swatmaxinfo;

		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/** '
	 * @name         :   countRec
	 * @param        :   Restaurant Menu
	 * @desc         :   The function is to count the Product details
	 * @return       :   Integer (Total number Of Product)
	 * Added By      :   zumry Deen
	 * Added On      :   22-08-2014
	 * Modified By   :   zumry Deen
	 * Modified On   :   04-09-2014
	 */
	public function countRec() {
		$totalNumberOfRec = 0;
		$arrWhere = array();
		try {
			 
			$SQL = "SELECT * FROM tbl_product ";
			if ($this->searchStr != '') {
				array_push($arrWhere, "product_name LIKE '" . "%" . $this->searchStr . "%" . "'");
			}


			if ($this->status != '') {
				array_push($arrWhere, "status =  '" . $this->status . "'");
			}


			if ($this->isFeatured != '') {
				array_push($arrWhere, "is_featured =  '" . $this->isFeatured . "'");
			}

			if ($this->isSpecialOffer != '') {
				array_push($arrWhere, "is_special_offers =  '" . $this->isSpecialOffer . "'");
			}

			if ($this->category != '') {
				//array_push($arrWhere, "tbl_category_id =  '" . $this->category . "'");
				array_push($arrWhere, "FIND_IN_SET ($this->category,`tbl_category_id`)>0");
			}
			if ($this->ProductsubCategory != '') {
				array_push($arrWhere, "tbl_sub_category_id =  '" . $this->ProductsubCategory . "'");
			}


			if ($this->categoryGroup) {
				$comma_separated_categories = implode(",", $this->categoryGroup);
				array_push($arrWhere, "tbl_category_id IN ($comma_separated_categories)");
			}

			if ($this->productBrand != '') {
				array_push($arrWhere, "product_brand =  '" . $this->productBrand . "'");
			}

			if ($this->productDesigner != '') {
				array_push($arrWhere, "tbl_designer_id =  '" . $this->productDesigner . "'");
			}


			if ($this->yoo_exclusive != '') {
				array_push($arrWhere, "yoo_exclusive =  '" . $this->yoo_exclusive . "'");
			}


			if ($this->maxprice != '') {
				array_push($arrWhere, "unit_price < '" . $this->maxprice . "'");
			}


			if (count($arrWhere) > 0)
				$SQL.= "WHERE " . implode(' AND ', $arrWhere);

			if ($this->productDescription != '') {


				$SQL.=" or product_description LIKE '" . "%". $this->productDescription ."%" . "'";
			}

			//echo $SQL;
			$dbResult = $this->executeSelectQuery($SQL);
			$productRes = $this->getResult();
			$totalNumberOfRec = count($productRes);
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
	 * Added By      :   zumrydeen@gmail.com
	 * Added On      :   22-08-2014
	 * Modified By   :   zumrydeen@gmail.com
	 * Modified On   :   22-08-2014
	 */


	public function getcomma() {
		$arrProduct = array();
		$arrWhere = array();


		try {


			if ($this->listParam == 'top-sellers') {

				$SQL = "SELECT `productId` As id,count(`productId`) as tot FROM `tbl_order_items` GROUP BY productId  ORDER BY tot Desc";
			}

			if ($this->listBrand == 'top-brands') {

				$SQL = "SELECT `product_brand` As id,count(`product_brand`) as tot FROM `tbl_product` GROUP BY product_brand  ORDER BY tot Desc";
			}
			 
			else {

				$SQL = "SELECT * FROM tbl_product ";

				//array_push($arrWhere, "tbl_category_id IN ( ,)");
				array_push($arrWhere, "tbl_category_id  LIKE ',%'");



				if (count($arrWhere) > 0)
					$SQL.= "WHERE " . implode(' AND ', $arrWhere);


				if ($this->listingOrder) {
					$SQL.= ' ORDER BY ' . $this->listingOrder;
				}
				 
				 
			}



			if ($this->limit) {
				$SQL.= $this->limit;
			}

			//echo $SQL;
			// exit();
			 
			$dbResult = $this->executeSelectQuery($SQL);
			$productRes = $this->getResult();

			// print_r($productRes);
			// exit;
			foreach ($productRes As $productRow) {
				$productId = $productRow['id'];
				$productInfo = $this->getProduct($productId);
				array_push($arrProduct, $productInfo);
			}
			return $arrProduct;

			 


		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}



	public function search() {
		$arrProduct = array();
		$arrWhere = array();

		 
		try {


			if ($this->listParam == 'top-sellers') {

				$SQL = "SELECT `productId` As id,count(`productId`) as tot FROM `tbl_order_items` GROUP BY productId  ORDER BY tot Desc";
			}

			if ($this->listBrand == 'top-brands') {

				$SQL = "SELECT `product_brand` As id,count(`product_brand`) as tot FROM `tbl_product` GROUP BY product_brand  ORDER BY tot Desc";
			}
			 
			else {

				$SQL = "SELECT * FROM tbl_product ";

				if ($this->searchStr != '') {
					array_push($arrWhere, "product_name LIKE '" . "%" . $this->searchStr . "%" . "'");
				}

				if ($this->isFeatured != '') {
					array_push($arrWhere, "is_featured =  '" . $this->isFeatured . "'");
				}

				if ($this->isSpecialOffer != '') {
					array_push($arrWhere, "is_special_offers =  '" . $this->isSpecialOffer . "'");
				}

				if ($this->status != '') {
					array_push($arrWhere, "status =  '" . $this->status . "'");
				}

				if ($this->category != '') {
					//FIND_IN_SET("$this->category", 'tbl_category_id' ) >0;
					array_push($arrWhere, "FIND_IN_SET ($this->category,`tbl_category_id`)>0");
				}
				if ($this->ProductsubCategory != '') {
					 
					array_push($arrWhere, "tbl_sub_category_id IN ($this->ProductsubCategory)");
					//array_push($arrWhere, "tbl_sub_category_id =  '" . $this->ProductsubCategory . "'");
				}


				if ($this->categoryGroup) {
					$comma_separated_categories = implode(",", $this->categoryGroup);
					array_push($arrWhere, "tbl_category_id IN ($comma_separated_categories)");
				}

				if ($this->productBrand != '') {
					array_push($arrWhere, "product_brand =  '" . $this->productBrand . "'");
				}

				if ($this->yoo_exclusive != '') {
					array_push($arrWhere, "yoo_exclusive =  '" . $this->yoo_exclusive . "'");
				}

				if ($this->productDesigner != '') {
					array_push($arrWhere, "tbl_designer_id =  '" . $this->productDesigner . "'");
				}

				if ($this->minprice != '') {
					array_push($arrWhere, "unit_price >='" . $this->minprice . "'");
				}

				if ($this->maxprice != '') {
					array_push($arrWhere, "unit_price <= '" . $this->maxprice . "'");
				}

				 

				if (count($arrWhere) > 0)
					$SQL.= "WHERE " . implode(' AND ', $arrWhere);


				 


				if ($this->productDescription != '') {
					 
					 
					$SQL.=" or product_description LIKE '" . "%". $this->productDescription ."%" . "'";
				}

				if ($this->listingOrder) {
					$SQL.= ' ORDER BY ' . $this->listingOrder;
				}
			}


			if ($this->limit) {
				$SQL.= $this->limit;
			}

			//echo $SQL;
			// exit();
			 
			$dbResult = $this->executeSelectQuery($SQL);
			$productRes = $this->getResult();

			// print_r($productRes);
			// exit;
			foreach ($productRes As $productRow) {
				$productId = $productRow['id'];
				$productInfo = $this->getProduct($productId);
				array_push($arrProduct, $productInfo);
			}
			return $arrProduct;

			 


		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}

	/*     * '
	 * @name         :   updateFeatured
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function updateFeatured() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$isFeatured = $this->isFeatured;
			$arrayData = array('is_featured' => $isFeatured);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}

	/*     * '
	 * @name         :   updateSpecialOffer
	* @param        :   ProductObject
	* @desc   :   The function is to edit a Product Listing order
	* @return       :   boolean
	* Added By      :   zumrydeen@gmail.com
	* Added On      :   04-09-2014
	* Modified By   :   zumry Deen
	* Modified On   :   04-09-2014
	*/

	public function updateSpecialOffer() {
		$isUpdated = false;
		try {

			$id = $this->id;
			$isSpecialOffer = $this->isSpecialOffer;
			$arrayData = array('is_special_offers' => $isSpecialOffer);
			//$this->update('pages',array('name'=>'Changed!'),array("ID = '" . 44 . "'","NAME = 'xxx'"));
			$arrWhere = array("id = '" . $id . "'");

			$isUpdated = $this->update('tbl_product', $arrayData, $arrWhere);

			return $isUpdated;
		} catch (Exception $e) {

		}

		throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>RestaurantMenu</em>, <strong>Function -</strong> <em>updateOrder()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
	}

	public function countProductByCategory($categoryId) {
		$totalNumberOfRec = 0;
		$arrWhere = array();
		try {
			$SQL = "SELECT * FROM tbl_product ";
			array_push($arrWhere, "status =  'Published'");
			array_push($arrWhere, "tbl_category_id =  '" . $categoryId . "'");

			if (count($arrWhere) > 0)
				$SQL.= "WHERE " . implode(' AND ', $arrWhere);

			$dbResult = $this->executeSelectQuery($SQL);
			$productRes = $this->getResult();
			$totalNumberOfRec = count($productRes);
			return $totalNumberOfRec;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}


	public function limit_words($string, $word_limit)
	{
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}

	public function getProductByPageName($pageName){
		$objProduct = new stdClass();
		try {
			if ($this->connect()) {
				$colums = '*';
				$where = "product_view_page_name =  '" . $pageName . "'";
				$this->select('tbl_product', $colums, $where);
				$productInfo = $this->getResult();
				$objProduct = $this->getProduct($productInfo['id']);
			}
			return $objProduct;
		} catch (Exception $e) {
			throw new PlusProException("<strong>Oops !, Error Class name -</strong>  <em>Page</em>, <strong>Function -</strong> <em>getPage()</em>, <strong>Exception -</strong> <em>" . $e->getMessage() . "</em>");
		}
	}


}

?>
