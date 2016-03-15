<div class="row">
    <div class="col-md-6">

        <form action="auction_list.php" method="POST">
            Category
            <select name="category">
                <option value=""></option>
                <option value="Car">Car</option>
                <option value="Mobile Phone">Mobile Phones</option>
                <option value="Laptop">Laptops</option>
                <option value="Jewellry">Jewellry</option>
                <option value="Miscellaneous">Miscellaneous</option>
            </select>
            Condition
            <select name="condition">
                <option value=""></option>
                <option value="Used">Used</option>
                <option value="Used - Like New">Used - Like New</option>
                <option value="New">New</option>
            </select>
            Sort by
            <select name="sortBy">
                <option value=""></option>
                <option value="Price">Price</option>
                <option value="Time">Time</option>
            </select>
            <input id="refine" name="refine" type="submit" value="Refine">
        </form>


    </div>
    <form action="auction_list.php" method="POST">
        <input id="search" name="searchField" type="text" style="width: 500px;"
               placeholder="Search by name, description or category of item!">
        <input id="submit" type="submit" value="Search">
    </form>
</div>
