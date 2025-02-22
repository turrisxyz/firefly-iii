<?php

/**
 * TimeCollection.php
 * Copyright (c) 2020 james@firefly-iii.org
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

namespace FireflyIII\Helpers\Collector\Extensions;

use Carbon\Carbon;
use FireflyIII\Helpers\Collector\GroupCollectorInterface;

/**
 * Trait TimeCollection
 */
trait TimeCollection
{
    /**
     * @param string $day
     * @return GroupCollectorInterface
     */
    public function dayAfter(string $day): GroupCollectorInterface
    {
        $this->query->whereDay('transaction_journals.date', '>=', $day);
        return $this;
    }

    /**
     * @param string $day
     * @return GroupCollectorInterface
     */
    public function dayBefore(string $day): GroupCollectorInterface
    {
        $this->query->whereDay('transaction_journals.date', '<=', $day);
        return $this;
    }

    /**
     * @param string $day
     * @return GroupCollectorInterface
     */
    public function dayIs(string $day): GroupCollectorInterface
    {
        $this->query->whereDay('transaction_journals.date', '=', $day);
        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaDayAfter(string $day, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $day): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->day >= (int) $day;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withMetaDate(string $field): GroupCollectorInterface
    {
        $this->joinMetaDataTables();
        $this->query->where('journal_meta.name', '=', $field);
        $this->query->whereNotNull('journal_meta.data');

        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaDayBefore(string $day, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $day): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->day <= (int) $day;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaDayIs(string $day, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $day): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return (int) $day === $transaction[$field]->day;
                }
            }

            return false;
        };
        $this->postFilters[] = $filter;
        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaMonthAfter(string $month, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $month): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->month >= (int) $month;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaMonthBefore(string $month, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $month): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->month <= (int) $month;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaMonthIs(string $month, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $month): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return (int) $month === $transaction[$field]->month;
                }
            }

            return false;
        };
        $this->postFilters[] = $filter;
        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaYearAfter(string $year, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $year): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->year >= (int) $year;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaYearBefore(string $year, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $year): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->year <= (int) $year;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function metaYearIs(string $year, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $year): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $year === (string) $transaction[$field]->year;
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param string $month
     * @return GroupCollectorInterface
     */
    public function monthAfter(string $month): GroupCollectorInterface
    {
        $this->query->whereMonth('transaction_journals.date', '>=', $month);
        return $this;

    }

    /**
     * @param string $month
     * @return GroupCollectorInterface
     */
    public function monthBefore(string $month): GroupCollectorInterface
    {
        $this->query->whereMonth('transaction_journals.date', '<=', $month);
        return $this;

    }

    /**
     * @param string $month
     * @return GroupCollectorInterface
     */
    public function monthIs(string $month): GroupCollectorInterface
    {
        $this->query->whereMonth('transaction_journals.date', '=', $month);
        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectDayAfter(string $day, string $field): GroupCollectorInterface
    {
        $this->query->whereDay(sprintf('transaction_journals.%s', $field), '>=', $day);
        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectDayBefore(string $day, string $field): GroupCollectorInterface
    {
        $this->query->whereDay(sprintf('transaction_journals.%s', $field), '<=', $day);
        return $this;
    }

    /**
     * @param string $day
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectDayIs(string $day, string $field): GroupCollectorInterface
    {
        $this->query->whereDay(sprintf('transaction_journals.%s', $field), '=', $day);
        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectMonthAfter(string $month, string $field): GroupCollectorInterface
    {
        $this->query->whereMonth(sprintf('transaction_journals.%s', $field), '>=', $month);
        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectMonthBefore(string $month, string $field): GroupCollectorInterface
    {
        $this->query->whereMonth(sprintf('transaction_journals.%s', $field), '<=', $month);
        return $this;
    }

    /**
     * @param string $month
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectMonthIs(string $month, string $field): GroupCollectorInterface
    {
        $this->query->whereMonth(sprintf('transaction_journals.%s', $field), '=', $month);
        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectYearAfter(string $year, string $field): GroupCollectorInterface
    {
        $this->query->whereYear(sprintf('transaction_journals.%s', $field), '>=', $year);
        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectYearBefore(string $year, string $field): GroupCollectorInterface
    {
        $this->query->whereYear(sprintf('transaction_journals.%s', $field), '<=', $year);
        return $this;
    }

    /**
     * @param string $year
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function objectYearIs(string $year, string $field): GroupCollectorInterface
    {
        $this->query->whereYear(sprintf('transaction_journals.%s', $field), '=', $year);
        return $this;
    }

    /**
     * Collect transactions after a specific date.
     *
     * @param Carbon $date
     *
     * @return GroupCollectorInterface
     */
    public function setAfter(Carbon $date): GroupCollectorInterface
    {
        $afterStr = $date->format('Y-m-d 00:00:00');
        $this->query->where('transaction_journals.date', '>=', $afterStr);

        return $this;
    }

    /**
     * Collect transactions before a specific date.
     *
     * @param Carbon $date
     *
     * @return GroupCollectorInterface
     */
    public function setBefore(Carbon $date): GroupCollectorInterface
    {
        $beforeStr = $date->format('Y-m-d 00:00:00');
        $this->query->where('transaction_journals.date', '<=', $beforeStr);

        return $this;
    }

    /**
     * Collect transactions created on a specific date.
     *
     * @param Carbon $date
     *
     * @return GroupCollectorInterface
     */
    public function setCreatedAt(Carbon $date): GroupCollectorInterface
    {
        $after  = $date->format('Y-m-d 00:00:00');
        $before = $date->format('Y-m-d 23:59:59');
        $this->query->where('transaction_journals.created_at', '>=', $after);
        $this->query->where('transaction_journals.created_at', '<=', $before);

        return $this;
    }

    /**
     * @param Carbon $date
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setMetaAfter(Carbon $date, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $date->startOfDay();
        $filter              = function (int $index, array $object) use ($field, $date): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->gte($date);
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param Carbon $date
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setMetaBefore(Carbon $date, string $field): GroupCollectorInterface
    {
        $this->withMetaDate($field);
        $filter              = function (int $index, array $object) use ($field, $date): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->lte($date);
                }
            }

            return true;
        };
        $this->postFilters[] = $filter;

        return $this;
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setMetaDateRange(Carbon $start, Carbon $end, string $field): GroupCollectorInterface
    {
        if ($end < $start) {
            [$start, $end] = [$end, $start];
        }
        $end = clone $end; // this is so weird, but it works if $end and $start secretly point to the same object.
        $end->endOfDay();
        $start->startOfDay();
        $this->withMetaDate($field);

        $filter              = function (int $index, array $object) use ($field, $start, $end): bool {
            foreach ($object['transactions'] as $transaction) {
                if (array_key_exists($field, $transaction) && $transaction[$field] instanceof Carbon
                ) {
                    return $transaction[$field]->gte($start) && $transaction[$field]->lte($end);
                }
            }

            return false;
        };
        $this->postFilters[] = $filter;
        return $this;

    }

    /**
     * @param Carbon $date
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setObjectAfter(Carbon $date, string $field): GroupCollectorInterface
    {
        $afterStr = $date->format('Y-m-d 00:00:00');
        $this->query->where(sprintf('transaction_journals.%s', $field), '>=', $afterStr);

        return $this;
    }

    /**
     * @param Carbon $date
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setObjectBefore(Carbon $date, string $field): GroupCollectorInterface
    {
        die('a');
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @param string $field
     * @return GroupCollectorInterface
     */
    public function setObjectRange(Carbon $start, Carbon $end, string $field): GroupCollectorInterface
    {
        $after  = $start->format('Y-m-d 00:00:00');
        $before = $end->format('Y-m-d 23:59:59');
        $this->query->where(sprintf('transaction_journals.%s', $field), '>=', $after);
        $this->query->where(sprintf('transaction_journals.%s', $field), '<=', $before);

        return $this;
    }

    /**
     * Set the start and end time of the results to return.
     *
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return GroupCollectorInterface
     */
    public function setRange(Carbon $start, Carbon $end): GroupCollectorInterface
    {
        if ($end < $start) {
            [$start, $end] = [$end, $start];
        }
        // always got to end of day / start of day for ranges.
        $startStr = $start->format('Y-m-d 00:00:00');
        $endStr   = $end->format('Y-m-d 23:59:59');

        $this->query->where('transaction_journals.date', '>=', $startStr);
        $this->query->where('transaction_journals.date', '<=', $endStr);

        return $this;
    }

    /**
     * Collect transactions updated on a specific date.
     *
     * @param Carbon $date
     *
     * @return GroupCollectorInterface
     */
    public function setUpdatedAt(Carbon $date): GroupCollectorInterface
    {
        $after  = $date->format('Y-m-d 00:00:00');
        $before = $date->format('Y-m-d 23:59:59');
        $this->query->where('transaction_journals.updated_at', '>=', $after);
        $this->query->where('transaction_journals.updated_at', '<=', $before);

        return $this;
    }

    public function yearAfter(string $year): GroupCollectorInterface
    {
        $this->query->whereYear('transaction_journals.date', '>=', $year);
        return $this;
    }

    public function yearBefore(string $year): GroupCollectorInterface
    {
        $this->query->whereYear('transaction_journals.date', '<=', $year);
        return $this;
    }

    public function yearIs(string $year): GroupCollectorInterface
    {
        $this->query->whereYear('transaction_journals.date', '=', $year);
        return $this;
    }

}
