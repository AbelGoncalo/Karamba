<?php

namespace App\Livewire\Site;

use Livewire\{Component,WithFileUploads};
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\{Item,Location as _Location,Cupon,Delivery,DeliveryDetail};
use Illuminate\Support\Facades\DB;
class CartComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    protected $listeners = ['remove'=>'remove','refresh'=>'refresh','getTotalItems'=>'getTotalItems'];

    public $edit,$qtd = [],$total,$location = [],$name,$lastname,$receipt,
    $province,$municipality,$street,$phone,$otherPhone,$paymenttype='Transferência',
    $otherAddress,$cuponValue,$locationCheced = [],$companyid;


    //Validação de finalização de encomenda
    public $rules = [
        'name'=>'required',
        'lastname'=>'required',
        'province'=>'required',
        'municipality'=>'required',
        'street'=>'required',
        'phone'=>'required',
        'otherPhone'=>'required',
        'paymenttype'=>'required',
        'receipt'=>'required|mimes:pdf'
    ];
    public $messages = [
    'name.required'=>'Obrigatório',
    'lastname.required'=>'Obrigatório',
    'province.required'=>'Obrigatório',
    'municipality.required'=>'Obrigatório',
    'street.required'=>'Obrigatório',
    'phone.required'=>'Obrigatório',
    'otherPhone.required'=>'Obrigatório',
    'paymenttype.required'=>'Obrigatório'
    ];
    public function render()
    {
        
        return view('livewire.site.cart-component',[
            'cartContent'=>Cart::getContent(),
            'locations'=>_Location::where('company_id','=',session('companyid'))->get()
        ])->layout('layouts.site.app');
    }

    public function mount()
    {
        try {
            foreach (Cart::getContent() as $key => $item) {
               $this->qtd[$key] = $item->quantity;
               $this->total += Abs($item->price * $item->quantity);
            }
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    //Metodo para remover item do carrinho

    public function isTrue($id)
    {
        try {
            $this->edit = $id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente remover este item? Não pode reverter a ação",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Remover',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'onConfirmed' => 'remove' 
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
    //Metodo para remover item do carrinho

    public function remove()
    {
        try {

           Cart::remove($this->edit);
           $this->total = 0;
           
           $this->alert('success', 'SUCESSO', [
            'toast'=>false,
            'position'=>'center',
            'timer'=>'1000',
            'timerProgressBar'=> true,
            'text'=>'Sua encomenda foi realizada com sucesso'
            ]);

            $cupon = Cupon::find(session('IDCUPON'));

            if ($cupon ) {
                if($cupon->type == 'percent')
                {
    
               
                 $discount = (Cart::getTotal() / 100 *  $cupon->value) ;
                    Session()->put('cupondiscount',$discount);
                    Session()->put('IDCUPON',$cupon->id);
    
                
                 $this->cuponValue = '';
    
                }else{
                    $discount = Cart::getTotal() -  $cupon->value;
                    Session()->put('cupondiscount',$discount);
                    Session()->put('IDCUPON',$cupon->id);
    
                   
    
                    $this->cuponValue = '';
                }
            }
           
          
            foreach (Cart::getContent() as $key => $item) {
                $this->total += Abs($item->price * $item->quantity);
             }
            
            
        if (count(\Cart::getContent()) == 0) {
            
            Session()->forget('cupondiscount');
            Session()->forget('locationvalue');
            Cart::clear();
            session()->forget('companyid');
            return redirect()->route('site.home');
        }

        $this->dispatch('getTotalItems');

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }

    //Acrescentar quantidade
    public function increase($id)
    {
    
        try {

          
            $item = Item::find($id);
            $this->total = 0;

            if ($this->qtd[$id] > $item->quantity) {
               
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'timer'=>'1000',
                    'timerProgressBar'=> true,
                    'text'=>'Quantidade Superior a disponível'
                ]);
            } else {
                # code...
                Cart::remove($id);
                
                Cart::add(array(
                    'id' => $item->id,
                    'name' => $item->description,
                    'price' => $item->price,
                    'quantity' => $this->qtd[$id],
                    'attributes' => array(
                        'image' => $item->image,

                    )
                ));

                $cupon = Cupon::find(session('IDCUPON'));
                if ($cupon ) {
                    if($cupon->type == 'percent')
                    {
        
                   
                     $discount = (Cart::getTotal() / 100 *  $cupon->value) ;
                        Session()->put('cupondiscount',$discount);
                        Session()->put('IDCUPON',$cupon->id);
        
                     
                     $this->cuponValue = '';
        
                    }else{
                        $discount = Cart::getTotal() -  $cupon->value;
                        Session()->put('cupondiscount',$discount);
                        Session()->put('IDCUPON',$cupon->id);
        
        
                        $this->cuponValue = '';
                    }
                }
               
              
                foreach (Cart::getContent() as $key => $item) {
                    $this->total += Abs($item->price * $item->quantity);
                 }




                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'timer'=>'1000',
                    'timerProgressBar'=> true,
                    'text'=>'Item '.$item->description.', adicionado'
                ]);
                $this->dispatch('getTotalItems');

            }
            

         } catch (\Throwable $th) {
             $this->alert('error', 'ERRO', [
                 'toast'=>false,
                 'position'=>'center',
                 'showConfirmButton' => true,
                 'confirmButtonText' => 'OK',
                 'text'=>'Falha ao realizar operação'
             ]);
         }

    }

    //Verificar cupon de desconto
    public function applyDiscount()
    {
        try {
           
            $cupon = Cupon::where('code','=',$this->cuponValue)
            ->where('company_id','=',auth()->user()->company_id ?? session('companyid'))
            ->first();
           
            if ($cupon) {
                if (date('Y-m-d') > $cupon->expirateDate) {
                    $this->alert('error', 'ERRO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Seu Cupon está espirado!'
                    ]);
                    $this->cuponValue = '';
                }elseif($cupon->times == 0){
                    $this->alert('error', 'ERRO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Cupon Inválido'
                    ]);


                }else{
                        
                    if($cupon->type == 'percent')
                    {

                   
                     $discount = (Cart::getTotal() / 100 *  $cupon->value) ;
                        Session()->put('cupondiscount',$discount);
                        Session()->put('IDCUPON',$cupon->id);

                        $cupon->times = $cupon->times - 1;
                        $cupon->save();
                     $this->cuponValue = '';

                    }else{
                        $discount = Cart::getTotal() -  $cupon->value;
                        Session()->put('cupondiscount',$discount);
                        Session()->put('IDCUPON',$cupon->id);

                        $cupon->times = $cupon->times - 1;
                        $cupon->save();

                        $this->cuponValue = '';
                    }

                }
                
            }else{
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Cupon Inválido'
                ]);
            }
            $this->dispatch('getTotalItems');

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
    //Verificar cupon de desconto
    public function increaseLocationPrice($id)
    {
        try {

            $location = _Location::find($id);
            if (count(Cart::getContent()) > 0) {
           
            if($location){

                Session()->put('locationvalue',$location->price);

            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Preço da localização não encontrada'
                ]);
            }

                
            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Nenhum item adicionado no carrinho!'
                ]);
            }
            $this->dispatch('getTotalItems');
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }

    //Verificar cupon de desconto
    public function finallyOrder()
    {
       
        $this->validate($this->rules,$this->messages);
        DB::beginTransaction();
        try {
            

            $receiptString = '';

            if($this->receipt)
            {
                $receiptString = md5($this->receipt->getClientOriginalName()).'.'.
                $this->receipt->getClientOriginalExtension();
                $this->receipt->storeAs('public/receipts/',$receiptString);

            }
            //GERAR CÓDIGO ÚNICO PARA CADA DETALHES
            $code = 'DLS'.rand(1000,5000);
            $delivery = Delivery::create([
                "total"=>Cart::getTotal() - session('cupondiscount') + session('locationvalue'),
                "discount"=>session('cupondiscount'),
                "locationprice"=>session('locationvalue'),
                "customername"=>$this->name,
                'customerlastname'=>$this->lastname,
                'customerprovince'=>$this->province,
                'customermunicipality'=>$this->municipality,
                'customerstreet'=>$this->street,
                'customerphone'=>$this->phone,
                'customerotherphone'=>$this->otherPhone,
                'customerpaymenttype'=>$this->paymenttype,
                'receipt'=>$receiptString,
                'customerotheraddress'=>$this->otherAddress,
                'finddetail'=>$code,
                'company_id'=>auth()->user()->company_id ?? session('companyid'),
            ]);

            if($delivery)
            {
                foreach (Cart::getContent() as $key => $value) {
                    DeliveryDetail::create([
                        "delivery_id"=>$delivery->id,
                        "item"=>$value->name,
                        "price"=>$value->price,
                        "quantity"=>$value->quantity,
                        'subtotal'=>$value->price * $value->quantity,
                        'company_id'=>auth()->user()->company_id ?? session('companyid'),
                    ]);
                }
            }
            if (session('IDCUPON') != null) {
                $cuponDecrease = Cupon::find(session('IDCUPON'));
                if($cuponDecrease->times != 0){
                    
                    $cuponDecrease->times -= 1;
                    $cuponDecrease->save();
                }
            }
            DB::commit();
            //Depois de todo processo for concluido limpar todos os campos
            //e redirecionar o cliente

            $this->clearFields();

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'timer'=>'1500',
                'text'=>'Sua encomenda foi realizada com sucesso'
            ]);
            Session()->put('finddetail',$code);

            return redirect()->to('/minhas/encomendas');

        } catch (\Throwable $th) {
            DB::rollBack();
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }



    public function clearFields()
    {
        try {
            $this->name = '';
            $this->lastname = '';
            $this->province = '';
            $this->municipality = '';
            $this->street = '';
            $this->phone = '';
            $this->otherPhone = '';
            $this->paymenttype = '';
            $this->otherAddress = '';
            $this->cuponValue = '';
            Session()->forget('cupondiscount');
            Session()->forget('locationvalue');
            Session()->forget('companyid');
            Cart::clear();


        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
}
