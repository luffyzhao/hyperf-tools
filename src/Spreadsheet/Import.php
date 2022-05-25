<?php

namespace LHyperfTools\Spreadsheet;

use LHyperfTools\Contracts\SheetImport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Import
{
    public Worksheet $worksheet;
    private SheetImport $import;

    /**
     * @param SheetImport $import
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function __construct(SheetImport $import)
    {

        $this->worksheet = IOFactory::load($import->getFile())
            ->getSheet($import->getSheet());

        $this->import = $import;
    }

    /**
     * @return \Generator
     */
    public function getRowIterator(): \Generator
    {
        foreach ($this->worksheet->getRowIterator($this->import->getStartRow(), $this->import->getEndRow()) as $row){
            $array = [];
            foreach ($row->getCellIterator($this->import->getStartColumn(), $this->import->getEndColumn()) as $cell){
                $array[$this->map($cell->getColumn())] = $cell->getValue();
            }
            yield $array;
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function map($key){
        $maps = $this->import->getMap();
        return $maps[$key] ?? $key;
    }
}