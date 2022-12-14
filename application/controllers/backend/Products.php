<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Products_model', 'products_md');

    }

    public function index()
    {
        $data['title'] = 'Products List';

        $data['lists'] = $this->products_md->select_all();

        $this->load->admin('products/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('brand_id', 'Brand', 'required|numeric');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('sales_prices	', 'Sales prices', 'required|numeric');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');
            $this->form_validation->set_message('numeric', 'Yalnızca rəqəm girilə bilər');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'description' => $this->security->xss_clean($this->input->post('description')),
                    'quantity' => $this->security->xss_clean($this->input->post('quantity')),
                    'price' => $this->security->xss_clean($this->input->post('price')),
                    'sales_prices' => $this->security->xss_clean($this->input->post('sales_prices')),
                    'brand_id' => $this->security->xss_clean($this->input->post('brand')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $insert_id = $this->products_md->insert($request_data);

                if ($insert_id > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                } else {
                    $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                }
            }
        }

        $data['title'] = 'Product List';

        $this->load->admin('products/create', $data);

    }

    public function edit($id)
    {

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('brand_id', 'Brand', 'required|numeric');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('sales_prices	', 'Sales prices', 'required|numeric');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');
            $this->form_validation->set_message('numeric', 'Yalnızca rəqəm girilə bilər');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'description' => $this->security->xss_clean($this->input->post('description')),
                    'quantity' => $this->security->xss_clean($this->input->post('quantity')),
                    'price' => $this->security->xss_clean($this->input->post('price')),
                    'sales_prices' => $this->security->xss_clean($this->input->post('sales_prices')),
                    'brand_id' => $this->security->xss_clean($this->input->post('brand')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $affected_rows = $this->products_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    redirect('backend/products/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/products/edit/' . $id);
                }
            }
        }

        $item = $this->products_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/products');
        }

        $data['item'] = $item;

        $data['title'] = 'Product Edit';

        $this->load->admin('products/edit', $data);

    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->products_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/products');
    }

}