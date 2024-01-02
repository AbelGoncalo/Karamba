
@section('title','Avaliar Serviços')
<div class="col-md-12 d-flex justify-content-center align-items-center flex-wrap mt-5">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-header card-review">
                <h4 class="text-center">AVALIE NOSSOS SERVIÇOS</h4>
            </div>
            <div class="body p-2">
                <div class="container">
                    <form  wire:submit="saveReview" method="post">
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
                        <label for="">Digite suas recomendações aqui</label>
                        <textarea wire:model='comment' name="comment" id="comment" cols="30" rows="5" placeholder="Digite alguma coisa" style="resize: none" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 text-end mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <button wire:click='redirectUser' class="btn btn-md btn-danger w-100">
                                    <i class="fa fa-times"></i>
                                    AGORA NÃO</button>

                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-md btn-primary-welcome-client w-100">
                                    <i class="fa fa-star"></i>
                                    AVALIAR</button>

                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
      
</div>
