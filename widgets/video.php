<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Video extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-video';
	}

	public function get_title() {
		return __( 'YouTube video', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_video_controls( $this );
	}
	
	public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		if ( ! $settings['dh_video_link'] ) {
			return;
		}

		$video_id = $this->get_video_id( $settings['dh_video_link'] )['id'] ?? false;
		$thumnail_url = $this->get_thumbnail_url( $video_id );

		if ( ! $thumnail_url || ! $video_id ) {
			return;
		}

		?>
		<div class="youtube-player-wrapper">
			<div class="youtube-video-player">

				<div id="video-<?php echo $this->get_id(); ?>" class="youtube-video-wrap" data-video-id="<?php echo $video_id; ?>"  data-player-id="video-<?php echo $this->get_id(); ?>">
		
					<img src="<?php echo $thumnail_url; ?>" class="video-thumb-img"/>

					<button class="ytp-large-play-button" aria-label="Watch video">
						<svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
							<path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#212121" fill-opacity="0.8"></path>
							<path d="M 45,24 27,14 27,34" fill="#fff"></path>
						</svg>
					</button>

				</div>

			</div>
		</div>
			<?php

			$post_id = get_the_ID();
			$page_videos = get_post_meta( $post_id, 'dh_page_video_cache', true ) ?: [];

			if ( ! isset( $page_videos[$video_id] ) ) {
				$api_key = "AIzaSyDasERdL6nKA92mi1eqCkfLxasAa6ytTsc";
				$url = "https://www.googleapis.com/youtube/v3/videos?id=" . $video_id . "&key=" . $api_key . "&part=snippet";
				$json = file_get_contents( $url );
				$page_videos[$video_id] = json_decode( $json , true );

				update_post_meta( $post_id, 'dh_page_video_cache', $page_videos );
			}

			// echo '<pre>' . print_r($page_videos, true) . '</pre><br>';

			$schema = array();
			$schema['@context'] = "https://schema.org/";
			$schema['@type'] = "VideoObject";
			$schema['name'] = $page_videos[$video_id]['items'][0]['snippet']['title'];
			$schema['description'] = $page_videos[$video_id]['items'][0]['snippet']['description'];
			$schema['uploadDate'] = $page_videos[$video_id]['items'][0]['snippet']['publishedAt'];
			$schema['thumbnailUrl'] = array_column( $page_videos[$video_id]['items'][0]['snippet']['thumbnails'], 'url' );


			$schema_json = json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			echo '<script type="application/ld+json">' . $schema_json . '</script>';

	}

	function get_video_id( $url ) {
		$queryString = parse_url( $url, PHP_URL_QUERY );
		parse_str( $queryString, $params );
		if ( isset( $params['list'] ) && strlen( $params['list'] ) > 0) {
			return array(
				'id' => $params['list'],
				'type' => 'list'
			);
		} elseif ( isset($params['v'] ) && strlen( $params['v'] ) > 0) {
			return array(
				'id' => $params['v'],
				'type' => 'single'
			);
		} else {
			$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
			if ( preg_match( $pattern, $url, $match ) ) {
				return array(
					'id' => $match[1],
					'type' => 'single'
				);
			} else {
				return false;
			}
		}
	}

	function get_thumbnail_url( $video_id ) {
		$thumb_url = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
		if ( ! file_get_contents( $thumb_url ) ) {
			$thumb_url = 'https://img.youtube.com/vi/' . $video_id . '/sddefault.jpg';
			if ( ! file_get_contents( $thumb_url ) ) {
				$thumb_url = 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
				if ( ! file_get_contents( $thumb_url ) ) {
					$thumb_url = 'https://img.youtube.com/vi/' . $video_id . '/mqdefault.jpg';
				} else {
					return false;
				}
			}
		}
		return $thumb_url;
	}
	
}