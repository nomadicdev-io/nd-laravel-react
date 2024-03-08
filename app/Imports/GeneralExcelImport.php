<?php
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GeneralExcelImport implements ToCollection, WithStartRow {

	protected $rows = [];

	public function __construct() {}

	public function collection(Collection $rows) {

	}

	public function startRow(): int {
		return 1;
	}
}