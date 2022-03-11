<?php

/**
 *
 */
class CSVToBrowser
{
    /**
     * @var
     */
    private $headerColumns;
    /**
     * @var
     */
    private $bodyColumns;

    /**
     * @var string
     */
    private $separator;

    /**
     * @param $headerColumns
     * @param String|null $separator
     */
    public function __construct($headerColumns, string $separator = null)
    {
        $this->headerColumns = $headerColumns;
        $this->separator = $separator ?? ';';
    }

    /**
     * @param $data
     * @return void
     */
    public function addRow($data): void
    {
        if (count($data) < count($this->headerColumns)) {
            $difference = count($this->headerColumns) - count($data);
            for ($i = 0; $i <= $difference; $i++) {
                $data[] = 'No data provided for this column';
            }
        }
        $this->bodyColumns[] = $data;
    }

    /**
     * @param string $outputName The filename output
     * @return void
     */
    public function generateCSV(string $outputName)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $outputName . 'csv');
        $fp = fopen('php://output', 'wb');
        //Write header
        fputcsv($fp, $this->headerColumns, ';');
        foreach ($this->bodyColumns as $row) {
            fputcsv($fp, $row, $this->separator);
        }
        fclose($fp);
    }


}
