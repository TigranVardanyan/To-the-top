<?php
/*
 * Plugin Name: To The Top
 * Plugin URI: https://github.com/TigranVardanyan/To-the-top
 * Description: Scroll to the top button
 * Version: 0.0.1
 * Author: Tigran Vardanyan
 * Author URI: https://www.mydailycode.ru/
 * License: GPLv2 or later
 */

class to_the_top extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'to_the_top', // Base ID
      esc_html__( 'To the top button', 'text_domain' ), // Name
      array( 'description' => esc_html__( 'To the top', 'text_domain' ), ) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }
    echo "<style>
            #to-the-top_button .triangle {
            width: 40px;
            height: 40px;
            border: 20px solid transparent;
            border-bottom: 20px solid #fff;
            position: absolute;
            top:calc(50% - 30px);
            left:calc(50% - 20px)
          }
            #to-the-top_button {
            width: 60px;
            height: 60px;
            border-radius: 26%;
            border: 2px solid transparent;
            background-color: #690;
            position: fixed;
            top: 80%;";
            echo $instance['side'].": 5%
            }";
    if($instance[ 'mobile' ]) {
      echo "";
    } else {
      echo "@media screen and (max-device-width: 600px) {
              #to-the-top_button{
              display: none!important;
            }";
    }
    echo "</style> ";
    echo "<div id='to-the-top_button' style=''>
            <div class='triangle' style=''></div>
          </div>
          <button onclick=\"scrollTop\">Scroll Top</button>
          <script type=\"text/javascript\">
            window.onload = function() {
              if(window.pageYOffset < "; echo $instance['appearance_position'].") {
                document.getElementById('to-the-top_button').style.display = \"none\";
              } else {
                document.getElementById('to-the-top_button').style.display = \"block\";
              }
            }
            window.onscroll =  function() {
              if(window.pageYOffset < "?> <?php echo $instance['appearance_position'];
    echo ") {
                document.getElementById('to-the-top_button').style.display = \"none\";
              } else {
                document.getElementById('to-the-top_button').style.display = \"block\";
              }
            }
            
            document.getElementById('to-the-top_button').addEventListener('click', function() {
              let s=window.pageYOffset;  
              let h=document.documentElement.scrollHeight;
              let timerId = setTimeout(function tick() {
                if(s>0) {
                    window.scroll(0,s-=  h*5/ "; echo $instance['animation_time']." );
                    timerId = setTimeout(tick, 5);
                  }
                  else { 
                    clearInterval(timerId);
                  }
              }, 5);    
            })  
          </script>";
    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    $side = ! empty( $instance['side'] ) ? $instance['side'] : esc_html__( 'Left or right', 'text_domain' );
    $appearance_position = ! empty( $instance['appearance_position'] ) ? $instance['appearance_position'] : esc_html__( 'Position when button is apperance', 'text_domain' );
    $mobile = ! empty( $instance['mobile'] ) ? $instance['mobile'] : esc_html__( 'Mobile visibility', 'text_domain' );
    $animation_time = ! empty( $instance['animation_time'] ) ? $instance['animation_time'] : esc_html__( 'Scroll animation time', 'text_domain' );
    ?>
    <p>

      <label>Choose an side:</label>
      <select id="<?php echo $this->get_field_id('side'); ?>" name="<?php echo $this->get_field_name('side'); ?>" class="widefat" style="width:100%;">
        <option <?php selected( $instance['side'], 'right'); ?> value="right">Right</option>
        <option <?php selected( $instance['side'], 'left'); ?> value="left">Left</option>
      </select>
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'appearance_position' ) ); ?>"><?php esc_attr_e( 'Appear when Y px:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'appearance_position' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'appearance_position' ) ); ?>" type="text" value="<?php echo esc_attr( $appearance_position ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'mobile' ); ?>"><?php esc_attr_e( 'Mobile visibility:', 'text_domain' ); ?></label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'mobile' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'mobile' ); ?>" name="<?php echo $this->get_field_name( 'mobile' ); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'animation_time' ) ); ?>"><?php esc_attr_e( 'Scroll animation time:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'animation_time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animation_time' ) ); ?>" type="text" value="<?php echo esc_attr( $animation_time ); ?>">
    </p>
    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['side'] = ( ! empty( $new_instance['side'] ) ) ? sanitize_text_field( $new_instance['side'] ) : '';
    $instance['appearance_position'] = ( ! empty( $new_instance['appearance_position'] ) ) ? sanitize_text_field( $new_instance['appearance_position'] ) : '';
    $instance['mobile'] = ( ! empty( $new_instance['mobile'] ) ) ? sanitize_text_field( $new_instance['mobile'] ) : '';
    $instance['animation_time'] = ( ! empty( $new_instance['animation_time'] ) ) ? sanitize_text_field( $new_instance['animation_time'] ) : '';
    $instance['side'] = $new_instance['side'];
    return $instance;
  }

} // class to_the_top

// register to_the_top widget
function register_to_the_top() {
  register_widget( 'to_the_top' );
}
add_action( 'widgets_init', 'register_to_the_top' );