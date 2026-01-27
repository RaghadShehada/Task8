<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:products,name',
            'price'       => 'required|numeric|min:0.01',
            'category_id' => 'nullable|exists:categories,id',

            'suppliers'   => 'nullable|array',
            'suppliers.*.selected'       => 'nullable|boolean',
            'suppliers.*.cost_price'     => 'required_with:suppliers.*.selected|numeric|min:0',
            'suppliers.*.lead_time_days' => 'required_with:suppliers.*.selected|integer|min:0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $suppliers = $this->input('suppliers', []);
            if (!empty($suppliers)) {
                $selected = collect($suppliers)->filter(fn($s) => isset($s['selected']) && $s['selected']);
                if ($selected->isEmpty()) {
                    $v->errors()->add('suppliers', 'يجب اختيار مورد واحد على الأقل.');
                }

                $ids = $selected->keys()->map(fn($id) => (int)$id)->all();
                if (!empty($ids)) {
                    $count = \App\Models\Supplier::whereIn('id', $ids)->count();
                    if ($count !== count($ids)) {
                        $v->errors()->add('suppliers', 'الموردون المختارون غير موجودين.');
                    }
                }
            }
        });
    }
}
