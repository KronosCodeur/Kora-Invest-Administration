<?php

namespace App\Utils;

use App\Repository\AccountRepository;
use App\Repository\InvestmentRepository;
use Exception;

class AccountNumberUtils
{
    private AccountRepository $accountRepository;
    private  InvestmentRepository $investmentRepository;

    /**
     * @param AccountRepository $accountRepository
     * @param InvestmentRepository $investmentRepository
     */
    public function __construct(AccountRepository $accountRepository, InvestmentRepository $investmentRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->investmentRepository = $investmentRepository;
    }

    private function generateNumber():string{
        try {
            $number = strval(random_int(1000000000000000, 9999999999999999));
        } catch (Exception) {
        }
        $finalNumber ='"';
        $count = 0;
        for ($index=0; $index<strlen($number);$index++){
            $count++;
            $finalNumber .=$number[$index];
            if ($count%4==0 && $count!=16){
                $finalNumber .= '-';
            }
        }
        return  trim($finalNumber,"\"");
    }
    public function generateAccountNumber():string{
        $number = $this->generateNumber();
        $account =$this->accountRepository->findOneBy(['number'=>$number]);
        while ($account){
            $number = $this->generateNumber();
            $account =$this->accountRepository->findOneBy(['number'=>$number]);
        }
        return $number;
    }
    public function generateInvestmentAccountNumber():string{
        $number = $this->generateNumber();
        $investment =$this->investmentRepository->findOneBy(['number'=>$number]);
        while ($investment){
            $number = $this->generateNumber();
            $investment =$this->investmentRepository->findOneBy(['number'=>$number]);
        }
        return $number;
    }
}