<form>
  <label for="delivery_date">配送日を選択してください。</label>
  <select name="delivery_date" id="delivery_date">
      @foreach($deliveryDates as $deliveryDate)
          <option value="{{ $deliveryDate }}">{{ $deliveryDate }}</option>
      @endforeach
  </select>
</form>
