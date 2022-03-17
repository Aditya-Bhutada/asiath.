<?php 
if ( !defined( 'ABSPATH' ) ) exit();

$current_range = isset( $_GET['range'] ) ? $_GET['range'] : '7_day';

$format = el_date_time_format_js();
$placeholder = date( el_date_time_format_js_reverse($format), current_time('timestamp') );


?>

<div class="vendor_wrap"> 

	<?php echo el_get_template( '/vendor/sidebar.php' ); ?>

	<div class="contents">
		<?php echo el_get_template( '/vendor/heading.php' ); ?>

		<?php 
			$id_user = get_current_user_id();
			$user_info = EL_Package::instance()->get_info_membership_by_user_id( $id_user );

			if( EL()->options->package->get('enable_package', 'yes') == 'yes' && $user_info['package'] ){ ?>
		
		<?php

			
			$list_membership = EL_Package::instance()->get_info_membership_by_user_id($id_user);


			$start_date_tmp = $list_membership['start_date_tmp'];
			$posted_event = EL_Package::instance()->get_number_created_event_by_current_user($start_date_tmp);

			$id_package = $list_membership['id_package'];
			$total_event = get_post_meta( $id_package, OVA_METABOX_EVENT.'package_total_event', true );
			$remaining_event =  ( $total_event == '-1' ) ? esc_html__( 'Unlimit','eventlist' ) : $total_event - $posted_event;
		?>
			<div class="report_membership">
				<h3 class="vendor_report"><?php esc_html_e( 'Membership Report', 'eventlist' ); ?></h3>

				<ul class="mem_report">
					<li>
						<label><?php esc_html_e( 'Status', 'eventlist' ); ?></label>
						<div class="value"><?php echo $list_membership['status'].' - '.$list_membership['renew_link']; ?></div>
					</li>
					<li>
						<label><?php esc_html_e( 'Expiration Date', 'eventlist' ); ?></label>
						<div class="value"><?php echo $list_membership['end_date']; ?></div>
					</li>
					<li>
						<label><?php esc_html_e( 'Remaining Events', 'eventlist' ); ?></label>
						<div class="value"><?php echo $remaining_event; ?></div>
					</li>
					<li>
						<label><?php esc_html_e( 'Posted Events', 'eventlist' ); ?></label>
						<div class="value"><?php echo $posted_event; ?></div>
					</li>
				</ul>
			</div>
			<br>
		<?php } ?>

		<div class="accounting">

			<h3 class="vendor_report">
				<?php esc_html_e( 'Report Sales', 'eventlist' ); ?>
			</h3>

			<ul class="filter">
				<li class="<?php echo ( 'year' === $current_range ) ? 'active' : ''; ?>">
					<a href="<?php echo add_query_arg( array( 'vendor' => 'general', 'range' => 'year' ), get_myaccount_page() ); ?>">
						<?php esc_html_e( 'Year', 'eventlist' ); ?>
					</a>
				</li>

				<li class="<?php echo ( 'last_month' === $current_range ) ? 'active' : ''; ?>">
					<a href="<?php echo add_query_arg( array( 'vendor' => 'general', 'range' => 'last_month' ), get_myaccount_page() ); ?>">
						<?php esc_html_e( 'Last Month', 'eventlist' ); ?>
					</a>
				</li>

				<li class="<?php echo ( 'month' === $current_range ) ? 'active' : ''; ?>">
					<a href="<?php echo add_query_arg( array( 'vendor' => 'general', 'range' => 'month' ), get_myaccount_page() ); ?>">
						<?php esc_html_e( 'This Month', 'eventlist' ); ?>
					</a>
				</li>

				<li class="<?php echo ( '7_day' === $current_range ) ? 'active' : ''; ?>">
					<a href="<?php echo add_query_arg( array( 'vendor' => 'general', 'range' => '7_day' ), get_myaccount_page() ); ?>">
						<?php esc_html_e( 'Last 7 days', 'eventlist' ); ?>
					</a>
				</li>

				<li class="custom <?php echo ( 'custom' === $current_range ) ? 'active' : ''; ?>">
					<span><?php esc_html_e( 'Custom:', 'eventlist' ); ?></span>
					<form method="GET">
						<div>
							<input type="hidden" name="vendor" value="general" />
							<input type="hidden" name="range" value="custom" />

							<input type="text" 
							size="16" 
							value="<?php echo ( ! empty( $_GET['start_date'] ) ) ? esc_attr( wp_unslash( $_GET['start_date'] ) ) : ''; ?>" 
							name="start_date" 
							class="range_datepicker from" 
							autocomplete="nope" autocorrect="off" autocapitalize="none" 
							placeholder="<?php echo esc_attr( $placeholder ); ?>" 
							data-format="<?php echo esc_attr( $format ); ?>" />
							<span>&ndash;</span>

							<input type="text" 
							size="16" 
							value="<?php echo ( ! empty( $_GET['end_date'] ) ) ? esc_attr( wp_unslash( $_GET['end_date'] ) ) : ''; ?>" 
							name="end_date"
							class="range_datepicker to" 
							autocomplete="nope" autocorrect="off" autocapitalize="none" 
							placeholder="<?php echo esc_attr( $placeholder ); ?>" 
							data-format="<?php echo esc_attr( $format ); ?>"  />

							<button type="submit" class="button" ><?php esc_html_e( 'Go', 'eventlist' ); ?></button>

						</div>
					</form>
				</li>
			</ul>

			<div class="chart">
				<div class="chart-sidebar">

					<?php 

					$range = isset( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : '7_day';
					if ( $range == 'custom' ) {
						$start_date = ( $_GET['start_date'] && isset( $_GET['start_date'] ) ) ? sanitize_text_field( $_GET['start_date'] ) : date( 'Y-m-d', strtotime('-3 years', current_time('timestamp') ) );
						$end_date = ( $_GET['end_date'] && isset( $_GET['end_date'] ) ) ? sanitize_text_field( $_GET['end_date'] ) : date('Y-m-d', current_time('timestamp') );
					} else {
						$start_date = isset( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : date( 'Y-m-d', strtotime('-10 years', current_time('timestamp') ) );
						$end_date = isset( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : date('Y-m-d', current_time('timestamp') );
					}

					$str_start_date = strtotime($start_date);
					$str_end_date = strtotime($end_date);

					$day_start_date = ( new DateTime($start_date) )->format('d');
					$month_start_date = ( new DateTime($start_date) )->format('m');
					$year_start_date = ( new DateTime($start_date) )->format('y');

					$day_end_date = ( new DateTime($end_date) )->format('d');
					$month_end_date = ( new DateTime($end_date) )->format('m');
					$year_end_date = ( new DateTime($end_date) )->format('y');

					$month_current_date = ( new DateTime() )->format('m');
					$year_current_date = ( new DateTime() )->format('y');

					$last_month_current_date = strtotime( date( 'Y-m-01', current_time( 'timestamp' ) ) );

					$first_day_current_month = strtotime( date( 'Y-m-01', current_time( 'timestamp' ) ) );
					$first_month_current_year = strtotime( date( 'Y-01-01', current_time( 'timestamp' ) ) );

					$last_month_current_year = strtotime( date( 'Y-12-01', current_time( 'timestamp' ) ) );

					$first_day_last_month = strtotime( date( 'Y-m-01', current_time( 'timestamp' ) ) );

					$currency = _el_symbol_price();
					$currency_position = EL()->options->general->get( 'currency_position','left' );

					$post_ID = [];

					// Query Event
					$args_base_event = array(
						'post_type' => 'event',
						'posts_per_page' => -1,
						'author' => wp_get_current_user()->ID,
					);

					$events = new WP_Query( $args_base_event );

					if( $events->have_posts() ): while ( $events->have_posts() ) : $events->the_post();
						$post_ID[] = get_the_ID();
					endwhile; wp_reset_query(); endif;

					if ( $range == '7_day' ) {
						$chart_interval = absint( ceil( max( 0, ( $str_end_date - strtotime( '-6 days', strtotime( 'midnight', current_time( 'timestamp' ) ) ) ) / ( 60 * 60 * 24 ) ) ) );

					} elseif ($range == 'month') {
						$chart_interval = absint( ceil( max( 0, ( $str_end_date - strtotime( date( 'Y-m-01', current_time( 'timestamp' ) ) ) ) / ( 60 * 60 * 24 ) ) ) );

					} elseif ($range == 'last_month') {
						$chart_interval = absint( floor( max( 0, ( strtotime( date( 'Y-m-t', strtotime( '-1 DAY', $first_day_current_month ) ) ) - strtotime( date( 'Y-m-01', strtotime( '-1 DAY', $first_day_current_month ) ) ) ) / ( 60 * 60 * 24 ) ) ) );

					} elseif ($range == 'year') {
						$chart_interval = ( new DateTime() )->format('m');

					} elseif ($range == 'custom') {
						$chart_interval = absint( ceil( max( 0, ( $str_end_date - $str_start_date ) / ( 60 * 60 * 24 ) ) ) );
					}

					// day, this month, last month, year
					if ( $range != 'custom' ) {

						if ( $range == 'year' ) {
							$chart_groupby = 'month';
							$i = $chart_interval;
						} else {
							$chart_groupby = 'day';
							$i = $chart_interval + 1;
						}

						while ( $i > 0  ) {
							$i--;
							if ( $range == 'last_month' ) {
								$after = date('Y-m-d', strtotime( ( '-' . $i ).' days', strtotime( '-1 DAY', $first_day_current_month ) ) );
								$before = $after;

							} elseif ( $range == 'year' ) {
								$after = date('Y-m-01',  strtotime( ('-' . $i . ' Month'), $last_month_current_date ) );
								$before = date( "Y-m-t", strtotime( $after ) );

							} else {
								$after = date('Y-m-d', strtotime( ( '-' . $i ).' days', strtotime( 'midnight', current_time( 'timestamp' ) ) ) );
								$before = $after;
							}

							// Query Booking
							$total_after_tax = accounting_get_total_after_tax( $post_ID, $after, $before );

							$data_total_after_tax[] = accounting_get_data_total_after_tax( $after, $total_after_tax );
						}
					}

					// Custom
					if ( $range == 'custom' && $chart_interval >= 100 ) {
						$chart_groupby = 'month';
						$count_month = 0;
						while ( ($str_start_date = strtotime("+1 MONTH", $str_start_date) ) <= $str_end_date) {
							$count_month++;
						}

						$m = ($count_month + 1);

						while ( $m >= 0 ) {
							if ( $m == $count_month + 1 ) {
								$after = date( ( $year_start_date . '-'. $month_start_date .'-' . $day_start_date ) );
								$after = date('Y-m-d',strtotime( $after ) );
								$before = date( "Y-m-t", strtotime( $after ) );

							} elseif ( ( $m > 0 ) && ( $m <= $count_month ) ) {
								$after = date('Y-m-01',  strtotime( ('-' .($m). ' month'), $last_month_current_date ) );
								$before = date( "Y-m-t", strtotime( $after ) );

							} elseif ( $m == 0 ) {
								$after = date( ( $year_end_date . '-'. $month_end_date .'-01' ) );
								$after = date('Y-m-d',strtotime( $after ) );
								$before = date('Y-m-d', $str_end_date);
							}

							// Query Booking
							$total_after_tax = accounting_get_total_after_tax( $post_ID, $after, $before );

							$data_total_after_tax[] = accounting_get_data_total_after_tax( $after, $total_after_tax );

							$m --;
						}
					} elseif ( $range == 'custom' && $chart_interval < 100 ) {
						$chart_groupby = 'day';
						$i = $chart_interval;
						while ( $i >= 0  ) {
							$after = date('Y-m-d', strtotime( ( '-' . $i ).' days', $str_end_date ) );
							$before = $after;

							// Query Booking
							$total_after_tax = accounting_get_total_after_tax( $post_ID, $after, $before );

							$data_total_after_tax[] = accounting_get_data_total_after_tax( $after, $total_after_tax );

							$i--;
						}
					}

					// Return data chart
					$data_chart = wp_json_encode( [ 
						$data_total_after_tax 
					] );

					$sum_total_after_tax = 0;

					foreach ($data_total_after_tax as $value) {
						$sum_total_after_tax += $value[1];
					}

					?>

				</div>

				<?php 
				$name_month = array_reduce(range(1,12),function($rslt,$m){ $rslt[$m] = date_i18n('M',mktime(0,0,0,$m,10)); return $rslt; });
				?>
				<div id="main_chart" style="width: 100%; height: 400px;" data-chart="<?php echo $data_chart; ?>" data-currency_position="<?php echo esc_attr($currency_position); ?>" data-currency="<?php echo esc_attr($currency); ?>" data-name_month="<?php echo wp_json_encode($name_month); ?>" >
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	jQuery(function($){
		var data_chart = $('#main_chart').data('chart');
		var currency = $('#main_chart').data('currency');
		var currency_position = $('#main_chart').data('currency_position');
		var name_month = $('#main_chart').data('name_month');

		var options = {
			lines: { show: true, lineWidth: 2, fill: false },
			points: { show: true, radius: 5, lineWidth: 2, fillColor: '#fff', fill: true },
			legend: { show: false },
			colors: [ '<?php echo get_theme_mod( 'chart_color', '#e86c60' ); ?>' ],
			grid: {
				color: '#aaa',
				borderColor: 'transparent',
				borderWidth: 0,
				hoverable: true
			},
			xaxes: [ {
				color: '#aaa',
				position: "bottom",
				tickColor: 'transparent',
				mode: "time",
				timeformat: "<?php echo ( 'day' === $chart_groupby ) ? '%d %b' : '%b'; ?>",
				monthNames: JSON.parse( decodeURIComponent( '<?php echo rawurlencode( wp_json_encode( array_values( $name_month ) ) ); ?>' ) ),
				minTickSize: [1, "<?php echo esc_js( $chart_groupby ); ?>"],
				tickLength: 1,
				font: {
					color: "#aaa"
				}
			} ],
			yaxes: [
			{
				min: 0,
				minTickSize: 1,
				tickDecimals: 0,
				color: '#d4d9dc',
				font: { color: "#aaa" }
			},
			{
				position: "right",
				min: 0,
				tickDecimals: 2,
				alignTicksWithAxis: 1,
				color: 'transparent',
				font: { color: "#aaa" }
			}
			],
			yaxis: {
				axisLabel: '%',
				axisLabelFontSizePixels: 12,
				tickFormatter: function (val, axis) {
					if (val != 0 ) {
						if ( currency_position == 'left' ) {
							return currency + val;
						} else if ( currency_position == 'left_space' ) {
							return currency + ' ' + val;
						} else if ( currency_position == 'right_space' ) {
							return val + ' ' + currency;
						} else {
							return val + currency;
						}
					} else {
						return val;
					}
				},
			}
		};

		if ($('#main_chart').length > 0) {

			$.plot("#main_chart", data_chart, options);
		}


		$("<div id='tooltip'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #eee",
			'border-radius': "5px",
			padding: "2px 0",
			"background-color": "#eee",
			opacity: 0.80,
			width: '150px',
			'text-align': 'center'
		}).appendTo("body");

		$("#main_chart").bind("plothover", function (event, pos, item) {
			
			if (!pos.x || !pos.y) {
				return;
			}

			if (item) {
				var x = item.datapoint[0].toFixed(0);
				var y = item.datapoint[1].toFixed(2);
				let date = new Date( parseInt(x) );

				var data_month_php = JSON.parse( decodeURIComponent( '<?php echo rawurlencode( wp_json_encode( array_values( $name_month ) ) ); ?>' ) );

				var monthName = data_month_php[date.getMonth()];

				var dayName = date.getDate();

				if ( currency_position == 'left' ) {
					$("#tooltip").html( dayName + " " + monthName + ": " + currency + y ).css({top: item.pageY-40, left: item.pageX-75}).fadeIn(200);

				} else if ( currency_position == 'left_space' ) {
					$("#tooltip").html( dayName + " " + monthName + ": " + currency + ' ' + y ).css({top: item.pageY-40, left: item.pageX-75}).fadeIn(200);

				} else if ( currency_position == 'right_space' ) {
					$("#tooltip").html( dayName + " " + monthName + ": " + y + ' ' + currency ).css({top: item.pageY-40, left: item.pageX-75}).fadeIn(200);

				} else {
					$("#tooltip").html( dayName + " " + monthName + ": " + y + currency ).css({top: item.pageY-40, left: item.pageX-75}).fadeIn(200);
				}
			} else {
				$("#tooltip").hide();
			}
		});

	});
</script>