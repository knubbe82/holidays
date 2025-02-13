<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Serbia extends Country
{
    protected function __construct(
        public ?string $region = null
    ) {
    }

    public function countryCode(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina - prvi dan' => '01-01',
            'Nova godina - drugi dan' => '01-02',
            'Božić' => '01-07',
            'Dan državnosti - prvi dan' => '02-15',
            'Dan državnosti - drugi dan' => '02-16',
            'Praznik rada - prvi dan' => '05-01',
            'Praznik rada - drugi dan' => '05-02',
            'Dan primirja u Prvom svetskom ratu' => '11-11',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(
            $this->orthodoxEaster($year)
        )->setTimezone('Europe/Belgrade');

        return [
            'Veliki petak' => $easter->subDays(2),
            'Vaskrs' => $easter,
            'Vaskršnji ponedeljak' => $easter->addDay(),
        ];
    }

    protected function orthodoxEaster(int $year): int
    {
        $timestamp = easter_date($year, CAL_EASTER_ALWAYS_JULIAN);
        $daysDifference = (int)($year / 100) - (int)($year / 400) - 2;

        return (int) strtotime("+$daysDifference days", $timestamp);
    }
}
