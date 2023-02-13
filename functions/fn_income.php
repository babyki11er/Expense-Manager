<?php


/*
Incomes:
    type    str
    amount  int
    date    str
    note    str
*/

function addIncome($label, $amount, $date, $note): bool
{
    $income =  [
        'label' => $label,
        'amount' => $amount,
        'date' => $date,
        'note' => $note
    ];
    $all_incomes = _readAllIncomes();
    $all_incomes[] = $income;
    return _saveAllIncomes($all_incomes);
}

function _getTotalIncome(): int
{
    $all_incomes = _readAllIncomes();
    $total = 0;
    foreach ($all_incomes as $income) {
        $total += $income['amount'];
    }
    return $total;
}

function getRemaining(): int
{
    $total_income = _getTotalIncome();
    $total_outcome = _getTotalOutcome();
    return $total_income - $total_outcome;
}

function _readAllIncomes(): array
{
    return _getDataFromFileName(INCOME_FN);
}

function _saveAllIncomes(array $all_incomes): bool
{
    return _writeDataToFile(INCOME_FN, $all_incomes);
}
