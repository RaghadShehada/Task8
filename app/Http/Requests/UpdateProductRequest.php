<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|unique:products,name,' . $this->product->id,
            'price' => 'required|numeric|min:0',

            
            'category_id' => 'nullable|exists:categories,id',

           
            'suppliers' => 'nullable|array',

            
            'suppliers.*.selected'       => 'nullable|boolean',
            'suppliers.*.cost_price'     => 'nullable|numeric|min:0',
            'suppliers.*.lead_time_days' => 'nullable|integer|min:0',
        ];
    }

    
    public function withValidator($validator)
    {
        $validator->after(function ($v) {

           
            if (!$this->has('suppliers')) {
                return;
            }

            $suppliers = $this->input('suppliers', []);

            $selected = collect($suppliers)
                ->filter(fn ($s) => !empty($s['selected']));

            if ($selected->isEmpty()) {
                $v->errors()->add('suppliers', 'يجب اختيار مورد واحد على الأقل.');
            }
        });
    }
}

