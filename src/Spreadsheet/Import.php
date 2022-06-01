<?php

namespace LHyperfTools\Spreadsheet;

use Hyperf\Utils\Str;
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
                $array[$this->map($cell->getColumn())] = $this->casts($cell->getColumn(), $cell->getValue());
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

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    protected function casts($key, $value){
        $casts = $this->import->getCasts();
        if(isset($casts[$key])){
            $method = 'call' . Str::ucfirst($casts[$key]);
            if(!method_exists($this, $method)){
                throw new \Exception($casts[$key] . '方法不存在！');
            }
            $value = $this->$method($value);
        }
        return $value;
    }

    /**
     * @param $value
     * @return string
     * @throws \Exception
     */
    protected function callString($value){
        $newValue = (string) $value;
        if($newValue == $value){
            return $newValue;
        }
        throw new \Exception('数据转换后出现了差异！');
    }

    /**
     * @param $value
     * @return string
     * @throws \Exception
     */
    protected function callInt($value){
        $newValue = (int) $value;
        if($newValue == $value){
            return $newValue;
        }
        throw new \Exception('数据转换后出现了差异！');
    }

    /**
     * @param $value
     * @return string
     * @throws \Exception
     */
    protected function callFloat($value){
        $newValue = (float) $value;
        if($newValue == $value){
            return $newValue;
        }
        throw new \Exception('数据转换后出现了差异！');
    }
}