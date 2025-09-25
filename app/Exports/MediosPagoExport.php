<?php

namespace App\Exports;

use App\Models\MediosPago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class MediosPagoExport implements FromCollection, WithHeadings{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = MediosPago::query();
        if ($this->request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $this->request->nombre . '%');
        }
        if ($this->request->filled('activo')) {
            $query->where('activo', $this->request->activo);
        }
        return $query->get(['id_medio_pago', 'nombre', 'descripcion', 'activo']);
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Descripción', 'Activo'];
    }
} 