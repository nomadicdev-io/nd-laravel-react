<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use \App\ExcelHelper;

class GeneralExcelExport implements FromArray, WithEvents {
	protected $request;
	protected $data;
	protected $opts;

	public function __construct($request, $data, $opts) {
		$this->request = $request;
		$this->data = $data;
		$this->opts = $opts;
	}

	public function registerEvents(): array{
		return [
			AfterSheet::class => function (AfterSheet $event) {
				if (!empty($this->opts['columns'])) {
					foreach ($this->opts['columns'] as $column => $config) {
						$event->sheet->getStyle($column)->applyFromArray(
							[
								'font' => $config,
							]
						);
					}
				}
			},
		];
	}
	public function array(): array
	{
		$result = [];
		$result[0] = $this->opts['headers'];
		$numberOfElements = count($result[0]);
		$i = 1;

		foreach ($this->data as $row) {
			$count = 0;
			foreach ($row as $col) {
				$result[$i][$count] = $col;
				$count++;
			}
			$i++;
		}
		return $result;
	}
}