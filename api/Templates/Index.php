<body>
    <header>
        <h1>Select Product and see prices in different currencies</h1>
    </header>
    
    <nav>
        <span>Select product</span>
        <select id="idItemSelect">
            <option>Select Item</option>
            <?php foreach ($this->_arrData as $objItem): ?>
            <option value="<?php echo $objItem->intId ?>"><?php echo $objItem->strTitle ?></option>
            <?php endforeach; ?>
        </select>
    </nav>

    <section>
        <div id="idItemInfo" class="clsInfoBox"></div>
        <div id="idItemRates" class="clsInfoBox"></div>
    </section>

    <footer>
            Copyrights &copy; 2016 Klearchos Douvantzis <a href="mailto:douvantzisklearhos@gmail.com">Email</a>
    </footer>
</body>