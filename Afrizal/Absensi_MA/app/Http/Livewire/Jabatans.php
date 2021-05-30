<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Jabatan;

class Jabatans extends Component
{
    public $jabatans, $Jabatan, $member_id;
    public $isModal = 0;

  	
    public function render()
    {
        $this->jabatans = Jabatan::orderBy('created_at', 'DESC')->get(); 
        return view('livewire.jabatans'); 
    }

    
    public function create()
    {
        
        $this->resetFields();
        $this->openModal();
    }

    public function closeModal()
    {
        $this->isModal = false;
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    
    public function resetFields()
    {
        $this->Jabatan = '';
        $this->member_id = '';
    }

    public function store()
    {
        
        $this->validate([
            'Jabatan' => 'required|string',
            
        ]);

        if($this->member_id==null){
            Jabatan::insert(array('Jabatan'=>$this->Jabatan));
        }else{
            Jabatan::where('id',$this->member_id)->update(array('Jabatan'=>$this->Jabatan));
        }
        
        session()->flash('message', $this->member_id!=null ? $this->Jabatan . ' Berhasil Diperbaharui': $this->Jabatan . ' Berhasil Ditambahkan');
        $this->closeModal(); 
        $this->resetFields(); 
    }

    
    public function delete($id)
    {
        $jabatan = Jabatan ::find($id); 
        $jabatan->delete();
        session()->flash('message', $jabatan->Jabatan . ' Berhasil Dihapus ');
    }


    
    public function edit($id)
    {
        
        $jabatan = Jabatan ::find($id); 
        $this->member_id = $id;
        $this->Jabatan = $jabatan->Jabatan;
           $this->openModal(); 
    }
}
