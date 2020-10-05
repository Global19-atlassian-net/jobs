<?php
/**
 * Template to show when submitting a resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/resume-submit.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.15.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wp_enqueue_script( 'wp-resume-manager-resume-submission' );
?>
<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-resume-form" class="job-manager-form" enctype="multipart/form-data">

    <?php do_action( 'submit_resume_form_start' ); ?>

    <?php if ( apply_filters( 'submit_resume_form_show_signin', true ) ) : ?>

        <?php get_job_manager_template( 'account-signin.php', array( 'class' => $class ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

    <?php endif; ?>

    <?php if ( resume_manager_user_can_post_resume() ) : ?>

        <!-- Resume Fields -->
        <?php do_action( 'submit_resume_form_resume_fields_start' ); ?>

        <?php foreach ( $resume_fields as $key => $field ) : ?>
          <?php
              ++$i;
              if ($i == 8) {
          ?>
            <div class="accordion" id="accordion-additional-info">
              <div class="card">
                <div class="card-header" id="heading-additional-info">
                  <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-additional-info" aria-expanded="false" aria-controls="collapse-additional-info">
                      Additional Info
                    </button>
                  </h2>
                </div>
                <div id="collapse-additional-info" class="collapse" aria-labelledby="heading-additional-info" data-parent="#accordion-additional-info">
                  <div class="card-body">
          <?php } ?>
                    <fieldset class="fieldset-<?php echo esc_attr( $key ); ?> fieldset-type-<?php echo esc_attr( in_array ( $field['type'], array( 'links', 'education', 'experience' ) ) ? 'repeated' : $field['type'] ); ?>">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . apply_filters( 'submit_resume_form_required_label', $field['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'front' ) . '</small>', $field ); ?></label>
                        <div class="field">
                            <?php $class->get_field_template( $key, $field ); ?>
                        </div>
                    </fieldset>
          <?php
              if ($i == 20  ) {
          ?>                    
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php endforeach; ?>

        <?php do_action( 'submit_resume_form_resume_fields_end' ); ?>

        <p>
            <?php wp_nonce_field( 'submit_form_posted' ); ?>
            <input type="hidden" name="resume_manager_form" value="<?php echo esc_attr( $form ); ?>" />
            <input type="hidden" name="resume_id" value="<?php echo esc_attr( $resume_id ); ?>" />
            <input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
            <input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
            <input type="submit" name="submit_resume" class="button" value="<?php echo esc_attr( $submit_button_text ); ?>" />
        </p>

    <?php else : ?>

        <?php do_action( 'submit_resume_form_disabled' ); ?>

    <?php endif; ?>

    <?php do_action( 'submit_resume_form_end' ); ?>
</form>
