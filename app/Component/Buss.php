<?php
/**
 * Created by IntelliJ IDEA.
 * User: shouwareogawa
 * Date: 2018/03/31
 * Time: 15:40
 */

namespace App\Component;


class Buss
{

    /**
     * バス代計算
     * @param int $price
     * @return int
     */
    public static function calc(int $price, string $passengers)
    {
        $devide = explode(',', $passengers);
        $i_free_count = 0;
        $in_count = 0;
        $iw_count = 0;

        // 人数数える
        foreach ($devide as $passenger) {
            $age_kb = mb_substr($passenger, 0, 1);
            switch ($age_kb) {
                case 'A':
                    $i_free_count += 2;
                    break;
                case 'I':
                    if ($passenger === 'Iw') {
                        $iw_count++;
                    } else if ($passenger === 'In') {
                        $in_count++;
                    }
                    break;
            }
        }

        $sum = 0;
        foreach ($devide as $passenger) {
            //$age_kb = mb_substr($passenger, 0, 1);
            // １回愚直に実装する
            switch ($passenger) {
                // 定期持ち
                case 'Ap':
                case 'Ip':
                case 'Cp':
                    break;
                // 通常料金
                case 'An':
                    $sum += $price;
                    break;
                // 通常料金の半額 １０円未満は切り上げ
                case 'Aw':
                    $sum += ceil(($price / 2) /10) * 10;
                    break;
                // 子供料金
                case 'Cn':
                    $sum += ceil(($price / 2) / 10) * 10;
                    break;
                case 'Cw':
                    $sum += ceil(($price / 4) / 10) * 10;
                    break;
                // 通常料金
                case 'In':
                    if ($i_free_count > 0 && $in_count > 0) {
                        $in_count--;
                        $i_free_count--;
                    } else {
                        $sum += ceil(($price / 2) / 10) * 10;
                    }
                    break;
                // 通常料金の半額 １０円未満は切り上げ
                case 'Iw':
                    if ($i_free_count > 0 && ($in_count === 0 || ($iw_count + $in_count <= $i_free_count))) {
                        $iw_count--;
                        $i_free_count--;
                    } else {
                        $sum += ceil(($price / 4) / 10) * 10;
                    }
                    break;
                default:
                    // not implement.
            }
        }

        return $sum;

    }
}