<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sls
{
    public function __construct()
    {
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function formatNumber($number, $decimals = 2)
    {
        $ds = '.';
        $ts = '';
        return number_format($number, $decimals, $ds, $ts);
    }
    public function formatQuantity($number, $decimals = 2)
    {
        $ds = '.';
        $ts = '';
        return number_format($number, $decimals, $ds, $ts);
    }

    public function formatDecimal($number, $decimals = 2)
    {
        if (!is_numeric($number)) {
            return null;
        }
        // if (!$decimals && $decimals !== 0) {
        //     $decimals = $this->Settings->decimals;
        // }
        return number_format($number, $decimals, '.', '');
    }

    public function formatMoney($number, $decimals = 2)
    {
        if (!is_numeric($number)) {
            return null;
        }
        // if (!$decimals && $decimals !== 0) {
        //     $decimals = $this->Settings->decimals;
        // }
        return number_format($number, $decimals, '.', '');
    }

    public function formatQuantityDecimal($number, $decimals = 2)
    {
        // if (!$decimals) {
        //     $decimals = $this->Settings->qty_decimals;
        // }
        return number_format($number, $decimals, '.', '');
    }

    public function slug($title, $type = null, $r = 1)
    {
        // $this->load->helper('text');
        $slug       = url_title(convert_accented_characters($title), '-', true);
        $check_slug = $this->checkSlug($slug, $type);
        if (!empty($check_slug)) {
            $slug = $slug . $r;
            $r++;
            $this->slug($slug, $type, $r);
        }
        return $slug;
    }

    public function checkSlug($slug, $type = null)
    {
        if (!$type) {
            return $this->db->get_where('products', ['slug' => $slug], 1)->row();
        } elseif ($type == 'category') {
            return $this->db->get_where('categories', ['slug' => $slug], 1)->row();
        } elseif ($type == 'brand') {
            return $this->db->get_where('brands', ['slug' => $slug], 1)->row();
        }
        return false;
    }

    public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }

    public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P')
    {
        $this->load->library('tec_mpdf');
        return $this->tec_mpdf->generate($content, $name, $output_type, $footer, $margin_bottom, $header, $margin_top, $orientation);
    }

    public function analyze_term($term)
    {
        //2111111250008
        $spos = strpos($term, $this->Settings->barcode_separator);
        // var_dump($spos); die;
        if ($spos !== false  && $spos != 0) {
            $st        = explode($this->Settings->barcode_separator, $term);
            $sr        = trim($st[0]);
            $option_id = trim($st[1]);
        } else {
            $sr        = $term;
            $option_id = false;
        }
        $barcode = $this->parse_scale_barcode($sr);
        if (!is_array($barcode)) {
            return ['term' => $sr, 'option_id' => $option_id];
        }
        return ['term' => $barcode['item_code'], 'option_id' => $option_id, 'quantity' => $barcode['weight'], 'price' => $barcode['price'], 'strict' => $barcode['strict'] ? ($this->site->getProductByCode($barcode['item_code']) ? false : true) : false];
    }

    public function parse_scale_barcode($barcode)
    {
        if (strlen($barcode) == $this->Settings->ws_barcode_chars) {
            
            $product = $this->site->getProductByCode($barcode);
            if ($product) {
                return $barcode;
            }
            $price  = false;
            $weight = false;
            if ($this->Settings->ws_barcode_type == 'price') {
                try {
                    $price = substr($barcode, $this->Settings->price_start - 1, $this->Settings->price_chars);
                    $price = $this->Settings->price_divide_by ? $price / $this->Settings->price_divide_by : $price;
                } catch (\Exception $e) {
                    $price = 0;
                }
            } else {
                try {
                    $weight = substr($barcode, $this->Settings->weight_start - 1, $this->Settings->weight_chars);
                    $weight = $this->Settings->weight_divide_by ? $weight / $this->Settings->weight_divide_by : $weight;
                } catch (\Exception $e) {
                    $weight = 0;
                }
            }
            $item_code = substr($barcode, $this->Settings->item_code_start - 1, $this->Settings->item_code_chars);

            return ['item_code' => $item_code, 'price' => $price, 'weight' => $weight, 'strict' => true];
        }
        return $barcode;
    }

    public function unset_data($ud)
    {
        if ($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return false;
    }
    public function barcode($text = null, $bcs = 'code128', $height = 74, $stext = 1, $get_be = false, $re = false)
    {
        $drawText = ($stext != 1) ? false : true;
        $this->load->library('tec_barcode', '', 'bc');
        return $this->bc->generate($text, $bcs, $height, $drawText, $get_be, $re);
    }
    public function qrcode($type = 'text', $text = '', $size = 2, $level = 'H', $sq = null, $svg = false)
    {
        if ($type == 'link') {
            $text = urldecode($text);
        }
        $this->load->library('tec_qrcode');
        $svgData = $this->tec_qrcode->generate(['data' => $text]);
        if ($svg) {
            return $svgData;
        }
        return "<img src='data:image/svg+xml;base64," . base64_encode($svgData) . "' alt='{$text}' class='qrimg' width='100' height='100' style='max-width:" . ($size * 40) . 'px;max-height:' . ($size * 40) . "px;'' />";
    }

    public function paid_opts($paid_by = null, $purchase = false, $empty_opt = false)
    {
        $opts = '';
        if ($empty_opt) {
            $opts .= '<option value="">' . lang('select') . '</option>';
        }
        $opts .= '
        <option value="cash"' . ($paid_by && $paid_by == 'cash' ? ' selected="selected"' : '') . '>' . lang('cash') . '</option>
        <option value="Cheque"' . ($paid_by && $paid_by == 'Cheque' ? ' selected="selected"' : '') . '>' . lang('cheque') . '</option>
        <option value="other"' . ($paid_by && $paid_by == 'other' ? ' selected="selected"' : '') . '>' . lang('other') . '</option>';
        
        return $opts;
    }

    public function base64url_encode($data, $pad = null)
    {
        $data = str_replace(['+', '/'], ['-', '_'], base64_encode($data));
        if (!$pad) {
            $data = rtrim($data, '=');
        }
        return $data;
    }
    

}