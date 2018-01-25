<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_preparehtml {

	protected $NN;
	
	/* Constructor */
	public function __construct($rules = array()){
		$this->NN =& get_instance();
		$this->NN->load->library('common');
		log_message('debug', "Common library initialized");
	}
	
	public function prepare_popular_attractions($data){
		$return_value = '';
		foreach($data as $items){
			$latest_thumb = ($this->NN->common->get_latest_thumb($items['attr_id'],'attraction'))?$this->NN->common->get_latest_thumb($items['attr_id'],'attraction'):'noimage.jpg';
			$rating = $this->NN->common->calculate_rating($items['attr_id'],'attraction');
			$return_value .= '<div class="card">
					<a class="link-wrapper" href="'.base_url().'attraction/'.$items['attr_seo_name'].'">
					<div class="card__hero">
						<img alt="'.$items['attr_seo_name'].'" class="card__image" src="'.thumbs_url($latest_thumb).'" />
					</div>
					<div class="card__content">
						<h2 class="card__name">'.$items['attr_name'].'</h2>
						<p class="card__description">'.substr($items['attr_description'],0,100).'...</p>
							<div class="left">
							<img src="'.images_url('rating-'.round($rating['rating'],0).'.png').'"/>
						</div>
						<div class="clearer"></div>
						<div class="left rating-value-review-count" style="">'.$rating['reviews'].'</div>
					</div>
				</a>
				</div>';
		}
		return $return_value;
	}
	
	public function prepare_latest_review($data){
		$return_value = '';
		foreach($data as $items){
			$rating = round($items['review_rating'],0);
			$return_value .= '<div class="left latest-review-block">
						<div class="left review-summary" >
							<h6>'.$items['review_title'].'</h6>
							<div class="input select rating-b"><img src="'.images_url('rating-'.$rating.'.png').'"/></div>
							<div class="clearer"></div>
							<div class="input select rating-b">'.$items['review_text'].'</div>
							<a href="'.base_url().'publicprofile/'.$items['user_id'].'">'.$items['user_name'].'</a>
							<span style="font-size:15px"> &raquo; </span>
							<a href="'.base_url().'attraction/'.$items['attr_seo_name'].'">'.$items['attr_name'].'</a>
						</div>
						
					</div>';
		}
		return $return_value;
	}
	
	public function prepare_destinations($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = ($this->NN->common->get_latest_thumb($items['attr_id'],'attraction'))?$this->NN->common->get_latest_thumb($items['attr_id'],'attraction'):'noimage.jpg';
				$return_value .= '<div class="left destination-block"><img src="'.thumbs_url($image).'" />
					<span class="left destination-title"><a href="'.create_link('destination/'.$items['dest_seo_name']).'">'.$items['dest_name'].'</a></span></div>';
			}
		}else{
			$return_value = "No destinations!";
		}
		return $return_value;
	}
		
	public function prepare_destinations_pages($data, $page, $perpage){
		$return_value = '';
		if($page == null || $page == 1) $start = 0;
		else $start = intval($page)*(intval($perpage)/2);
		$end = $start + $perpage -1;
		if($end > count($data)) $end=(count($data)-1);
		if($data){
			for($start; $start <= $end; $start++){
				$image = ($this->NN->common->get_latest_thumb($data[$start]['attr_id'],'attraction'))?$this->NN->common->get_latest_thumb($data[$start]['attr_id'],'attraction'):'noimage.jpg';
				$return_value .= '<div class="left destination-block"><img src="'.thumbs_url($image).'" />
					<span class="left destination-title"><a href="'.create_link('destination/'.$data[$start]['dest_seo_name']).'">'.$data[$start]['dest_name'].'</a></span></div>';
			}
		}else{
			$return_value = "No destinations!";
		}
		return $return_value;
	}
	
	public function prepare_listtypes($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$return_value .= '<div class="left destination-block"><img src="'.images_url($items[2]).'" />
					<span class="left destination-title"><a href="'.create_link('explore/'.strtolower($items[1])).'">'.$items[0].'</a></span></div>';
			}
		}else{
			$return_value = "No Types Defined!";
		}
		return $return_value;
	}
	
	public function prepare_attractions($data){
		$return_value = '';
		foreach($data as $items){
			$latest_review = ($this->NN->common->get_latest_review($items['attr_id'],'attraction'))?'"'.$this->NN->common->get_latest_review($items['attr_id'],'attraction').'"':'No Reviews yet';
			$latest_thumb = ($this->NN->common->get_latest_thumb($items['attr_id'],'attraction'))?$this->NN->common->get_latest_thumb($items['attr_id'],'attraction'):'noimage.jpg';
			$rating = $this->NN->common->calculate_rating($items['attr_id'],'attraction');
			$return_value .= '<div class="card">
					<a class="link-wrapper" href="'.base_url().'attraction/'.$items['attr_seo_name'].'">
					<div class="card__hero"><img alt="'.$items['attr_seo_name'].'" class="card__image" src="'.thumbs_url($latest_thumb).'" /></div>
					<div class="card__content">
						<h2 class="card__name">'.$items['attr_name'].'</h2>
						<div class="left"><strong>'.$items['category_name'].'</strong></div>
						<div class="clearer"></div>
						<!--p class="card__description">'.substr($items['attr_description'],0,150).'...</p -->
						<div class="left" style="margin-bottom:3px;padding:3px 0;font-style:italic;">'.$latest_review.'</div>
						<div class="clearer"></div>
						<div class="left">
							<img src="'.images_url('rating-'.round($rating['rating'],0).'.png').'"/>
						</div>
						<div class="clearer"></div>
						<div class="left rating-value-review-count" style="">'.$rating['reviews'].'</div>
					</div>
				</a>
				</div>';
		}
		return $return_value;
	}
	
	public function prepare_attractions_page($data,$page,$perpage){
		$return_value = '';
		if($page == null || $page == 1) $start = 0;
		else $start = intval($page)*(intval($perpage)/2);
		$end = $start + $perpage -1;
		if($end > count($data)) $end=(count($data)-1);
		if($data){
			for($start; $start <= $end; $start++){
				if($end > count($data)) continue;
				$latest_review = ($this->NN->common->get_latest_review($data[$start]['attr_id'],'attraction'))?'"'.$this->NN->common->get_latest_review($data[$start]['attr_id'],'attraction').'"':'No Reviews yet';
				$latest_thumb = ($this->NN->common->get_latest_thumb($data[$start]['attr_id'],'attraction'))?$this->NN->common->get_latest_thumb($data[$start]['attr_id'],'attraction'):'noimage.jpg';
				$rating = $this->NN->common->calculate_rating($data[$start]['attr_id'],'attraction');
				//$rating = round($rating_array['rating'],0);
				$return_value .= '<div class="card">
					<a class="link-wrapper" href="'.base_url().'attraction/'.$data[$start]['attr_seo_name'].'">
					<div class="card__hero"><img alt="'.$data[$start]['attr_seo_name'].'" class="card__image" src="'.thumbs_url($latest_thumb).'" /></div>
					<div class="card__content">
						<h2 class="card__name">'.$data[$start]['attr_name'].'</h2>
						<div class="clearer"></div>
						<div class="left"  style="margin-bottom:3px;"><strong>'.$data[$start]['category_name'].'</strong></div>
						<div class="clearer"></div>
						<!--p class="card__description">'.substr($data[$start]['attr_description'],0,150).'...</p -->
						<div class="left" style="margin-bottom:3px;padding:3px 0;font-style:italic;">'.$latest_review.'</div>
						<div class="left">
							<img src="'.images_url('rating-'.round($rating['rating'],0).'.png').'"/>
						</div>
						<div class="clearer"></div>
						<div class="left rating-value-review-count" style="">'.$rating['reviews'].'</div>
					</div>
				</a>
				</div>';
			}
		}else{
			$return_value = 'No related attractions. Your suggestions count.';
		}
		return $return_value;
	}
		
	public function prepare_category_list($data){
		$return_value = '';
		if($data){
			$return_value .= '<li><a href="'.create_link('explore/attractions').'">All</a></li>';
			foreach($data as $items){
				$return_value .= '<li><a href="'.create_link('explore/attractions/?f='.$items['category_name']).'&i='.$items['category_id'].'">'.$items['category_name'].'</a></li>';
			}
		}else{
			$return_value = '<li><a href="#">No Options</a></li>';
		}
		return $return_value;
	}
	
	public function prepare_sponsored($data){
		if($data){
			$return_value = '';
			$return_value .='<!-- sponsored block -->
				<div class="left sponsored-block" id="sponsored-block">';
			foreach($data as $items){
				$latest_thumb = ($this->NN->common->get_latest_thumb($items['listing_id'],'listing'))?$this->NN->common->get_latest_thumb($items['listing_id'],'listing'):'noimage.jpg';
				$rating = $this->NN->common->calculate_rating($items['listing_id'],'listing');
				$return_value .= '<div class="left biz-block">
						<div class="image"><img src="'.thumbs_url($latest_thumb).'"/></div>
						<div class="content">
							<span class="title"><a href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a></span></br>
							<span class="latest-review">'.$items['sponsored_tagline'].'</span>
							<div class="input select rating-s"><img style="height:12px;" src="'.images_url('rating-'.round($rating['rating'],0).'.png').'"/></div>
							<div class="clearer"></div>
							<div class="left latest-review">'.$rating['reviews'].'</div>
						</div>
					</div>';
			}
			$return_value .= '<div class="sponsored-info"><a href="'.base_url().'advertisement">Ads</a></div>
				</div><!-- end of sponsored block -->';
		}else{
			$return_value = "";
		}
		return $return_value;
	}
		
	public function prepare_listings($data){
		if($data){
			$return_value = '';
			foreach($data as $items){
				$latest_review = $this->NN->common->get_latest_review($items['listing_id'],'listing');
				$latest_thumb = ($this->NN->common->get_latest_thumb($items['listing_id'],'listing'))?$this->NN->common->get_latest_thumb($items['listing_id'],'listing'):'noimage-s.jpg';
				$rating_array = $this->NN->common->calculate_rating($items['listing_id'],'listing');
				$rating = round($rating_array['rating'],0);
				$return_value .= '<div class="left biz-block">
						<div class="image"><img src="'.thumbs_url($latest_thumb).'"/></div>
						<div class="content">
							<span class="title"><a href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a></span></br>
							<span class="latest-review">'.$latest_review.'</span>
							<div class="input select rating-s"><img style="height:12px" src="'.images_url('rating-'.$rating.'.png').'"/></div>
							<div class="clearer"></div>
							<div class="left latest-review">'.$rating_array['reviews'].'</div>
						</div>
					</div>'; 
			}
		}else{
			$return_value = "";
		}
		return $return_value;
	}
	public function prepare_single_listings($items){
		if($items){
			$return_value = '';
			$latest_thumb = ($this->NN->common->get_latest_thumb($items['listing_id'],'listing'))?$this->NN->common->get_latest_thumb($items['listing_id'],'listing'):'noimage-s.jpg';
			$rating_array = $this->NN->common->calculate_rating($items['listing_id'],'listing');
			$return_value .= '<div class="left biz-block" style="width:250px;">
				<div class="image"><img src="'.thumbs_url($latest_thumb).'"/></div>
					<div class="content">
						<span class="title"><a href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a></span></br>
						<span>'.$items['category_name'].'</span></br>
						<span>Rated '.$rating_array['rating'].' out of 5</span></br>
					</div>
				</div>'; 
		}else{
			$return_value = "No Items!";
		}
		return $return_value;
	}
	
	public function prepare_listings_with_distance($source_location,$origin_name,$data){
		if($data){
			$return_value = '';
			foreach($data as $items){
				// Get the distance from google api
				$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$source_location .'&destinations='. $items['listing_lat'].','.$items['listing_lon'];
				// Trap the error of file_get_contents				
				$distance_details = json_decode(file_get_contents($url));
				if(isset($distance_details->rows[0]->elements[0]->distance->text)){
					$distance = $distance_details->rows[0]->elements[0]->distance->text." from ". $origin_name;
				}else{
					$distance = "Error calculating distance.";
				}
				// Retrieve the latest thumbnail
				$latest_thumb = ($this->NN->common->get_latest_thumb($items['listing_id'],'listing'))?$this->NN->common->get_latest_thumb($items['listing_id'],'listing'):'noimage-s.jpg';
				$rating_array = $this->NN->common->calculate_rating($items['listing_id'],'listing');
				$rating = round($rating_array['rating'],0);
				$return_value .= '<div class="left biz-block-wrap" style="width:315px;margin-bottom:5px;">
					<div class="left biz-block" style="width:100%;height:auto;">
						<div class="image">
							<img src="'.thumbs_url($latest_thumb).'"/>
						</div>
						<div class="content" style="width:230px;">
							<span class="title"><a href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a></span></br>
							<span class="latest-review">'.$distance.'</span>
							<div class="input select rating-s"><img style="height:12px" src="'.images_url('rating-'.$rating.'.png').'"/></div>
							<div class="clearer"></div>
							<div class="left review-count" style="margin:0;">'.$rating_array['reviews'].'</div>
						</div>
					</div></div>'; 
			}
		}else{
			$return_value = "";
		}
		return $return_value;
	}
	
	public function prepare_reviews($data){
		if($data){
			$return_value = '';
			foreach($data as $items){
				$rating = round($items['review_rating'],0);
				$user_image =  ($this->NN->common->get_latest_thumb($items['user_id'],'avatar'))?
				thumbs_url($this->NN->common->get_latest_thumb($items['user_id'],'avatar')):thumbs_url('userimage.jpg');
				$return_value .= '<div class="left review-block">
						<div class="left review-block-user" style="border-bottom:1px solid #ececec;">
							<div class="left review-block-avatar"><img src="'.$user_image.'" width="50"/></div>
							<div class="clearer"></div>
							<div class="review-block-userdetail">
								<p><a href="'.base_url().'user/public/'.$items['user_id'].'">'.$items['user_name'].'</a></p>
								<p>Member since: '.$items['user_join_date'].'</p>
							</div>
						</div>
						<div class="right review-block-review">
							<div class="images/review-block-reviewtitle">
							<h3>'.$items['review_title'].'</h3></div>
							<div class="input select rating-b"><img src="'.images_url('rating-'.$rating.'.png').'"/></div>
							<div class="clearer"></div>
							<p style="margin-top:5px;">'.$items['review_text'].'</p>
							<p>Reviewed on '.$items['review_date'].'</p>
						</div>
					</div>';
				}
			}else{
				$return_value = "<p style='padding-left:5px;margin-top:10px;'>No reviews, be the first to review.</p>";
			}
			return $return_value;
	}
	
	public function prepare_single_review($data){
		if($data){
			$return_value = '';
			foreach($data as $items){
				if($items['review_relation']=='attraction'){
					$_seo_name = $this->NN->common->get_column_value('attractions','attr_seo_name','attr_id',$items['review_relation_id']);
					$_name = $this->NN->common->get_column_value('attractions','attr_name','attr_id',$items['review_relation_id']);
					$_link = 'Review of <strong>'.$_name.'</strong> | <a href="'.create_link('attraction/'.$_seo_name).'">read all reviews</a>';
				}else{
					$_seo_name = $this->NN->common->get_column_value('listings','listing_seo_name','listing_id',$items['review_relation_id']);
					$_name = $this->NN->common->get_column_value('listings','listing_name','listing_id',$items['review_relation_id']);
					$_link = 'Review of <strong>'.$_name.'</strong> | <a href="'.create_link('biz/'.$_seo_name).'">read all reviews</a>';
				}
				$return_value .= '<div style="padding:12px">
						<h3>'.$items['review_title'].'</h3>'.$_link.'
						<p>By <a href="'.base_url().'user/public/'.$items['user_id'].'">'.$items['user_name'].'</a> | Member since: '.$items['user_join_date'].'</p>
						<p style="margin-top:5px;">'.$items['review_text'].'</p>
						</div>';
			}
		}else{
			$return_value = "No details found";
		}
		return $return_value;
	}
	
	public function prepare_pagination_links($data){
		if($data){
			return $data;
		}else{
			return null;
		}
	}
	
	/******************************** PHOTOS ************************/
	public function prepare_photos($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$return_value .= '<div class="left destination-block" style="margin:2px;border:none;">
					<a class="photosa" href="'.create_link('uploads/images/'.$items['media_file']).'" style="">
						<img src="'.thumbs_url($items['media_file']).'" />
					</a>
						<!--span class="left destination-title">
						<a href="'.create_link('uploads/images/'.$items['media_file']).'">'.$items['media_relation'].'</a>
					</span -->
				</div>';
			}
		}else{
			$return_value = "No Photos!";
		}
		return $return_value;
	}
	
	public function prepare_banner($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$return_value .= '<li><img src="'.photos_url($items['media_file']).'"/></li>';
			}
		}else{
			$return_value = "No Photos!";
		}
		return $return_value;
	}
	
	/****************************************************************/
	
	/************************ User info ******************************/
	/*
	public function prepare_user_basic_info($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = ($this->NN->common->get_latest_thumb($items['user_id'],'avatar'))?$this->NN->common->get_latest_thumb($items['user_id'],'avatar'):'noimage.jpg';
				$return_value .='
					<div class="info_box" style="position:relative;float:left;border-right:1px solid #d7d7d7;padding-right:15px;">
						<img width="150" src="'.avatar_url($image).'" /><br />
						<div><a href="#">change</a></div>
						<div class="user_info" style="position:relative;float:left">
							<div class="info_line"><span class="name"><strong>Name : </strong></span><span class="value">'.$items['user_name'].'</span></div>
							<div class="info_line"><span class="name"><strong>Email : </strong></span><span class="value">'.$items['user_email'].'</span></div>
							<div class="info_line"><span class="name"><strong>Country : </strong></span><span class="value">'.$items['user_country'].'</span></div>
							<div class="info_line"><span class="name"><strong>City : </strong></span><span class="value">'.$items['user_city'].'</span></div>
							<div class="info_line"><span class="name"><strong>Phone : </strong></span><span class="value">'.$items['user_phone'].'</span></div>
							<div class="info_line"><a id="user_edit_info" href="#">Edit Info</a> <a id="change_password" href="#">Change Password</a></div>
						</div>
					</div>';
			}
		}else{
			$return_value = "Some error occured";
		}
		return $return_value;
	}*/
	
	public function prepare_user_pending_list($data,$type){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('comment.png');
				$return_value .='<div class="list" style="border-bottom:1px solid #ececec;padding-bottom:2px;">
					<span class="icon"><img src="'.$image.'"&nbsp;</span>
					<span class="title" style="padding:2px 5px;">'.$items['review_title'].'</span>
					<span class="action" style="float:right;">
						<a href="#" id="edit" class="edit" style="background:url(http://localhost/neonepal/public/images/pencil.png) top left no-repeat;padding:0 5px;margin:0 3px"></a>
						<a id="delete" class="delete" href="#"style="background:url(http://localhost/neonepal/public/images/delete.png) top left no-repeat;padding:0 5px;margin:0 3px"></a>
					</span>
				</div>';
			}
		}else{
			$return_value = "Nothing Pending";
		}
		return $return_value;
	}
	
	public function prepare_user_wishlist($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('bookmark.png');
				$return_value .='<div class="left wishlist" style="border-radius:3px;background:#0077ff;padding:2px;margin:3px;">
					<span class="icon"><img src="'.$image.'"/>&nbsp;</span>
					<span class="wishlisttitle" style="padding:3px;">
						<a style="text-decoration:none;color:#fff;" href="'.base_url().'attraction/'.$items['attr_seo_name'].'">'.$items['attr_name'].'</a>
					</span>
					<span class="action" style="float:right;">
						<a class="remove_user_wishlist" href="'.base_url().'user/remove_user_wishlist/'.$items['user_list_id'].'/'.$items['user_id'].'" style="text-decoration:none;color:#333;padding:2px 5px;margin:0 2px">X</a>
					</span>
				</div>';
			}
		}else{
			$return_value = "Nothing Pending";
		}
		return $return_value;
	}
	
	public function prepare_user_checkins($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('check.png');
				$return_value .='<div class="left check_fav_item" style="border-radius:3px;background:#0077ff;padding:2px;margin:3px;">
					<span class="icon"><img src="'.$image.'"/>&nbsp;</span>
					<span class="check_fav_item_title" style="padding:2px 5px;">
						<a style="text-decoration:none;color:#fff;" href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a>
					</span>
					<span class="action" style="float:right;"></span>
				</div>';
			}
		}else{
			$return_value = "No Checkins";
		}
		return $return_value;
	}
	
	public function prepare_user_favs($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('heart-s.png');
				$return_value .='<div class="left check_fav_item" style="border-radius:3px;background:#0077ff;padding:2px;margin:3px;">
					<span class="icon"><img src="'.$image.'"/>&nbsp;</span>
					<span class="check_fav_item_title" style="padding:2px 5px;">
						<a style="text-decoration:none;color:#fff;" href="'.base_url().'biz/'.$items['listing_seo_name'].'">'.$items['listing_name'].'</a>
					</span>
					<span class="action" style="float:right;"></span>
				</div>';
			}
		}else{
			$return_value = "No Favourites";
		}
		return $return_value;
	}
	
	public function prepare_user_been_destinations($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('marker.png');
				$return_value .='<div class="list" style="position:relative;float:left;padding-bottom:2px;margin-right:5px;">
					<span class="icon"><img src="'.$image.'"/></span>
					<span class="title" style="font-size:12px;color:#000;padding:2px 5px;"><a href="'.base_url().'destination/'.$items['dest_seo_name'].'">'.$items['dest_name'].'</a></span>
				</div>';
			}
		}else{
			$return_value = '<div class="list" style="position:relative;float:left;padding-bottom:2px;margin-right:5px;">
					<span class="title" style="font-size:12px;color:#000;padding:2px 5px;">No destinations</span>
				</div>';
		}
		return $return_value;
	}
	
	public function prepare_user_been_attractions($data){
		$return_value = '';
		if($data){
			foreach($data as $items){
				$image = images_url('marker.png');
				$return_value .='<div class="list" style="position:relative;float:left;padding-bottom:2px;margin-right:5px;">
					<span class="icon"><img src="'.$image.'"/></span>
					<span class="title" style="font-size:12px;color:#000;padding:2px 5px;"><a href="'.base_url().'attraction/'.$items['attr_seo_name'].'">'.$items['attr_name'].'</a></span>
				</div>';
			}
		}else{
			$return_value = '<div class="list" style="position:relative;float:left;padding-bottom:2px;margin-right:5px;">
					<span class="title" style="font-size:12px;color:#000;padding:2px 5px;">No destinations</span>
				</div>';
		}
		return $return_value;
	}
	/*****************************************************************/
	
	public function prepare_attr_more_details($data){
		$return_value = '';
		if($data){
			foreach($data as $item){
			$image = isset($item['detail_name_icon'])?images_url($item['detail_name_icon']):images_url('check.png');
			if($item['detail_name'] === 'Website'){
				$item['detail_value'] = '<a style="text-decoration:none;color:#fff;" href="http://'.$item['detail_value'].'">'.$item['detail_value'].'</a>';
			}
				$return_value .='<div class="left check_fav_item" style="border-radius:3px;background:#0077ff;padding:2px;margin-right:3px;margin-bottom:3px;">
					<!--span class="icon" style="margin-left:5px;"><img src="'.$image.'"/></span-->
					<span class="check_fav_item_title" style="padding:2px;">
						<span style="text-decoration:none;color:#fff;"><strong>'.$item['detail_name'].' </strong>:'.$item['detail_value'].'</span>
					</span>
				</div>';
			}
		}else{
			$return_value .='<div class="left check_fav_item" style="border-radius:3px;background:#0077ff;padding:2px;margin-right:3px;margin-bottom:3px;">
					<span class="check_fav_item_title" style="padding:2px;">
						<span style="text-decoration:none;color:#fff;">No additional info...</span>
					</span>
				</div>';
		}	
		return $return_value;
	}
}