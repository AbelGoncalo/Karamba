<div wire:ignore.self class="modal fade" id="review-item-site" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
       
        <div class="modal-header">
          <h5 style=" color:#222831 " class="modal-title" id="exampleModalLabel">AVALIAR ITEM</h5>
          <button  type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form action="" class="container">
          <div class="rating-css">
            <div class="star-icon">
                <input type="radio" wire:model='stars' value="1" name="product_rating" checked id="rating1">
                <label for="rating1" ><i class="fa fa-star"></i></label>
                <input type="radio" wire:model='stars' value="2" name="product_rating" id="rating2">
                <label for="rating2" ><i class="fa fa-star"></i></label>
                <input type="radio" wire:model='stars' value="3" name="product_rating" id="rating3">
                <label for="rating3" ><i class="fa fa-star"></i></label>
                <input type="radio" wire:model='stars' value="4" name="product_rating" id="rating4">
                <label for="rating4" ><i class="fa fa-star"></i></label>
                <input type="radio" wire:model='stars' value="5" name="product_rating" id="rating5">
                <label for="rating5" ><i class="fa fa-star"></i></label>
            </div>
        </div>
        <div class="form-group">
            <label for="">Seja o primeiro a avaliar</label>
            <textarea maxlength="50" wire:model='comment' name="comment" id="comment" cols="30" rows="5" placeholder="Digite alguma coisa" style="resize: none" class="form-control"></textarea>
        </div>
         </form>
         
        </div>
        <div class="modal-footer">
          <button type="button" wire:click='saveReview' class="btn btn-md w-100" style="background: #ffbe33; color:#fff ">ENVIAR</button>
       </div>
      </div>
    </div>
  </div>