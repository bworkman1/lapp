<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
            exit;
        }
    }

    public function init_page()
    {
        $this->output->enable_profiler(PROFILER);

        $this->load->css('assets/themes/admin/vendors/bootstrap/dist/css/bootstrap.min.css');
        $this->load->css('assets/themes/admin/vendors/font-awesome/css/font-awesome.min.css');
        $this->load->css('assets/themes/admin/vendors/nprogress/nprogress.css');
        $this->load->css('assets/themes/admin/vendors/iCheck/skins/flat/green.css');
        $this->load->css('assets/themes/admin/vendors/google-code-prettify/bin/prettify.min.css');
        $this->load->css('assets/themes/admin/vendors/select2/dist/css/select2.min.css');
        $this->load->css('assets/themes/admin/vendors/switchery/dist/switchery.min.css');
        $this->load->css('assets/themes/admin/vendors/starrr/dist/starrr.css');
        $this->load->css('assets/themes/admin/vendors/bootstrap-daterangepicker/daterangepicker.css');
        $this->load->css('assets/themes/admin/css/alertify/alertify.core.css');
        $this->load->css('assets/themes/admin/css/alertify/alertify.default.css');
        $this->load->css('assets/themes/admin/build/css/custom.min.css');
        $this->load->css('assets/themes/admin/build/css/style.css');

        $this->load->js('assets/themes/admin/vendors/jquery/dist/jquery.min.js');
        $this->load->js('assets/themes/admin/vendors/bootstrap/dist/js/bootstrap.min.js');
        $this->load->js('assets/themes/admin/vendors/fastclick/lib/fastclick.js');
        $this->load->js('assets/themes/admin/vendors/nprogress/nprogress.js');
        $this->load->js('assets/themes/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');
        $this->load->js('assets/themes/admin/vendors/iCheck/icheck.min.js');
        $this->load->js('assets/themes/admin/vendors/moment/min/moment.min.js');
        $this->load->js('assets/themes/admin/js/alertify/alertify.min.js');
        $this->load->js('assets/themes/admin/vendors/bootstrap-daterangepicker/daterangepicker.js');
        $this->load->js('assets/themes/admin/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js');
        $this->load->js('assets/themes/admin/vendors/jquery.hotkeys/jquery.hotkeys.js');
        $this->load->js('assets/themes/admin/vendors/google-code-prettify/src/prettify.js');
        $this->load->js('assets/themes/admin/vendors/jquery.tagsinput/src/jquery.tagsinput.js');
        $this->load->js('assets/themes/admin/vendors/switchery/dist/switchery.min.js');
        $this->load->js('assets/themes/admin/vendors/select2/dist/js/select2.full.min.js');
        $this->load->js('assets/themes/admin/vendors/parsleyjs/dist/parsley.min.js');
        $this->load->js('assets/themes/admin/vendors/autosize/dist/autosize.min.js');
        $this->load->js('assets/themes/admin/vendors/starrr/dist/starrr.js');
        $this->load->js('assets/themes/admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js');
        $this->load->js('assets/themes/admin/build/js/custom.js');
        $this->load->js('assets/themes/admin/vendors/mask/jquery.mask.min.js');
        $adminSettings = $this->session->userdata('settings');
        $this->load->js('https://maps.googleapis.com/maps/api/js?key='.$adminSettings['google_api_key'].'&libraries=places');
        $this->load->js('assets/themes/lapp/js/app.js');

        $this->output->set_template('admin-left-menu');
    }

    public function index()
    {
        redirect(base_url('forms/all-forms'));
        exit;
    }

    public function add_form()
    {
        $this->init_page();

        $group = 'Add New Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect(base_url('request-error'));
            exit;
        }

        $this->load->model('Form_model');
        $data['validation_options'] = $this->Form_model->getValidationRules();
        $data['inputs'] = $this->Form_model->getSavedInputs();

        $this->load->view('forms/add-form', $data);
    }

    public function save_form()
    {
        $returns = array(
            'success' => false,
            'msg' => 'Invalid form values',
            'errors' => array(),
        );

        $group = 'Add New Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            echo json_encode($returns);
            exit;
        }

        $this->load->model('Form_model');

        $newName = true;

        $form_id = (int)$_POST['form_id'];
        if(!empty($form_id)) {
            $savedFrom = $this->Form_model->getFormById($form_id);
            if($savedFrom['form_settings']['name'] == $_POST['name']) {
                $newName = false;
            }
        }

        if($newName) {
            $this->form_validation->set_rules(
                'name', 'form name',
                'required|min_length[2]|max_length[255]|is_unique[forms.name]',
                array(
                    'required' => 'You have not provided a %s.',
                    'is_unique' => 'This %s already exists.'
                )
            );
        }

        $this->form_validation->set_rules(
            'cost', 'form cost',
            'max_length[10]|decimal|greater_than_equal_to['.$_POST["min"].']',
            array(
                'required'      => 'You have not provided a %s.',
                'decimal'     => '%s must be formatted as a currency value (50.00).',
                'greater_than_equal_to'     => 'Cost must be greater then or equal to min payment.'
            )
        );

        $this->form_validation->set_rules(
            'min', 'min cost',
            'max_length[10]|decimal',
            array(
                'required'      => 'You have not provided a %s.',
                'decimal'     => '%s must be formatted as a currency value (24.99).'
            )
        );

        $this->form_validation->set_rules('header', 'header', 'max_length[1000]');
        $this->form_validation->set_rules('footer', 'footer', 'max_length[1000]');
        $this->form_validation->set_rules('footer', 'footer', 'max_length[1000]');
        $this->form_validation->set_rules('active', 'active', 'max_length[5]');


        if ($this->form_validation->run() == FALSE) {
            $returns['errors'] = validation_errors_array();
        } else {
            $returns = $this->Form_model->saveFormValues($_POST);
        }

        echo json_encode($returns);
    }

    public function format_validation_rules()
    {
        $this->load->model('Form_model');
        $return = $this->Form_model->checkForValidValidation($_POST);
        echo json_encode($return);
    }

    public function add_input()
    {
        $this->load->model('Form_model');
        $results = $this->Form_model->addNewFormInput($_POST);

        echo json_encode($results);
    }

    public function delete_input()
    {
        $this->load->model('Form_model');
        $results = $this->Form_model->deleteInput($_POST);

        echo json_encode($results);
    }

    public function get_form_input()
    {
        $this->load->model('Form_model');
        echo json_encode($this->Form_model->getSingleFormInput($_POST));
    }

    public function view_form()
    {
        $group = 'View Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect('request-error');
        }

        $formId = (int)$this->uri->segment(3);
        if(!$formId) {
            show_404();
            exit;
        }

        $this->init_page();

        $this->load->model('Form_model');
        $data['warning'] = 'Viewing Form Only, Will Not Submit';
        $data['form'] = $this->Form_model->getFormById($formId);
        if(empty($data['form'])) {
            show_404();
        }

        $this->load->view('forms/show-form', $data);
    }

    public function all_forms()
    {
        $this->init_page();

        $group = 'View Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect('request-error');
        }

        $this->load->model('Form_model');
        $data['forms'] = $this->Form_model->getForms();
        $this->load->view('forms/all-forms', $data);
    }

    public function toggle_form()
    {
        $group = 'Edit Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            echo json_encode(array('success' => false, 'msg' => 'You don\'t have access to this feature.'));
            exit;
        }

        $this->load->model('Form_model');
        echo json_encode($this->Form_model->toggleFormAvailability($_POST));
    }

    public function edit_form()
    {
        $group = 'Edit Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect(base_url('request-error'));
            exit;
        }

        $formId = (int)$this->uri->segment(3);
        if(!$formId) {
            show_404();
            exit;
        }

        $this->init_page();

        $this->load->model('Form_model');

        $data['form'] = $this->Form_model->getFormById($formId);
        if(empty($data['form'])) {
            show_404();
            exit;
        }

        $data['validation_options'] = $this->Form_model->getValidationRules();

        $this->Form_model->formId = $formId;
        $data['inputs'] = $this->Form_model->getSavedInputs();

        $this->load->view('forms/edit-form', $data);
    }

    public function submit_form_manually()
    {
        $group = 'Submit Forms Manually';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect(base_url('request-error'));
            exit;
        }

        $formId = (int)$this->uri->segment(3);
        if(!$formId) {
            show_404();
            exit;
        }

        $this->init_page();
        $this->load->model('Form_model');

        $data['form'] = $this->Form_model->getFormById($formId);
        $this->load->view('forms/enter-form-manually', $data);
    }

    public function save_user_form()
    {
        $this->load->model('Form_submit_model');
        $data = isset($_POST['form']) ? $_POST['form'] : array();
        $this->Form_submit_model->submitForm($data);

        echo json_encode($this->Form_submit_model->feedback);
    }

    public function form_submissions()
    {
        $group = 'View Submitted Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect(base_url('request-error'));
            exit;
        }

        $this->init_page();
        $this->load->model('Form_model');

        $limit = (int)$this->input->post('limit') == '' ? $this->session->userdata('submission_limit') : $this->input->post('limit');
        $this->session->set_userdata('submission_limit', $limit);

        $limit = $limit != '' ? $limit : 20;
        $start = $this->uri->segment('5') != '' ? $this->uri->segment('5') : 0;
        $search = $this->input->post('search');

        if(isset($_POST['form_names'])) {
            $form_id = $_POST['form_names'];
            if($form_id == 'all') {
                $this->session->unset_userdata('search_form_submission_name');
            } elseif((int)$form_id > 0) {
                $this->session->set_userdata('search_form_submission_name', $form_id);
            } else {
                $this->session->unset_userdata('search_form_submission_name');
            }
        }


        $submittedForms = $this->Form_model->getSubmittedForms($search, $start, $limit);

        $data['forms'] = $this->Form_model->getAllFormNames();
        $data['table'] = $this->Form_model->formatSubmittedFormsTable($submittedForms, $start);
        $data['links'] = $this->Form_model->paginationResults($limit, 'pull-right');

        $this->load->view('forms/form-submissions', $data);
    }

    public function view_submitted_form()
    {
        $group = 'View Submitted Forms';
        if (!$this->ion_auth->in_group($group) && !$this->ion_auth->is_admin()) {
            redirect(base_url('request-error'));
            exit;
        }

        $this->init_page();

        $this->load->model('Form_model');

        $submissionId = (int)$this->uri->segment(3);
        $formId = $this->Form_model->convertSubmissionIdToFormId($submissionId);
        if($formId) {
            $this->load->model('Payment_model');

            $data = $this->Form_model->getSubmittedFormById($formId['form_id'], $submissionId);

            if(!empty($data['form'])) {
                $title = htmlentities($data['form']['form_settings']['name']);
                $this->output->set_common_meta($title, '', '');
            }

            $data['payment'] = '';
            if(isset($data['values'])) {
                $data['payments'] = $this->Payment_model->getPaymentsByFormSubmission($submissionId);
            }
            $this->load->view('forms/view-submitted-form', $data);

        } else {
            show_404();
        }
    }

    public function delete_form()
    {
        $this->load->model('Form_model');

        if($this->ion_auth->is_admin()) {
            $submissionId = (int)$this->uri->segment(3);
            $feedback = $this->Form_model->deleteForm($submissionId);
        } else {
            $feedback = array(
                'success' => false,
                'msg' => 'You don\'t have the permission to delete this form. Only admins can delete forms',
            );
        }
        echo json_encode($feedback);
    }

}