<?php
/**
 * BillUpdateRequest.php
 * Copyright (c) 2019 james@firefly-iii.org
 *
 * This file is part of Firefly III (https://github.com/firefly-iii).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace FireflyIII\Http\Requests;

use FireflyIII\Models\Bill;
use FireflyIII\Support\Request\ChecksLogin;
use FireflyIII\Support\Request\ConvertsDataTypes;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BillUpdateRequest.
 */
class BillUpdateRequest extends FormRequest
{
    use ConvertsDataTypes, ChecksLogin;

    /**
     * Returns the data required by the controller.
     *
     * @return array
     */
    public function getBillData(): array
    {
        return [
            'name'               => $this->string('name'),
            'amount_min'         => $this->string('amount_min'),
            'currency_id'        => $this->integer('transaction_currency_id'),
            'currency_code'      => '',
            'amount_max'         => $this->string('amount_max'),
            'date'               => $this->getCarbonDate('date'),
            'end_date'           => $this->getCarbonDate('bill_end_date'),
            'extension_date'     => $this->getCarbonDate('extension_date'),
            'repeat_freq'        => $this->string('repeat_freq'),
            'skip'               => $this->integer('skip'),
            'notes'              => $this->stringWithNewlines('notes'),
            'active'             => $this->boolean('active'),
            'object_group_title' => $this->string('object_group'),
        ];
    }

    /**
     * Rules for this request.
     *
     * @return array
     */
    public function rules(): array
    {
        /** @var Bill $bill */
        $bill = $this->route()->parameter('bill');

        return [
            'name'                    => sprintf('required|between:1,255|uniqueObjectForUser:bills,name,%d', $bill->id),
            'amount_min'              => 'required|numeric|gt:0|max:1000000000',
            'amount_max'              => 'required|numeric|gt:0|max:1000000000',
            'transaction_currency_id' => 'required|exists:transaction_currencies,id',
            'date'                    => 'required|date',
            'bill_end_date'           => 'nullable|date',
            'extension_date'          => 'nullable|date',
            'repeat_freq'             => sprintf('required|in:%s', join(',', config('firefly.bill_periods'))),
            'skip'                    => 'required|integer|gte:0|lte:31',
            'active'                  => 'boolean',
        ];
    }
}
