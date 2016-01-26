function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;

    
    this.showRecords = function(from, to) {        
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row
        for (var i = 1; i < rows.length; i++) {
            if (i < from || i > to)  
                rows[i].style.display = 'none';
            else
                rows[i].style.display = '';
        }
    }
    
    this.showPage = function(pageNumber) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';
        
        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-active';
        
        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    }   

    // new added function for first and last pagination function
    this.first = function() {
        this.showPage(1);
    }

    this.last = function() {
        // if (this.currentPage != this.pages) {
        //     this.currentPage = this.pages;
        //     this.showPage(this.currentPage)
        // };
        this.showPage(this.pages);
    }
    // end of new added function
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }                        
    
    this.init = function() {
        var rows = document.getElementById(tableName).rows;
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
    	
    	var pagerHtml = '<li><a onclick="' + pagerName + '.first();" class="pg-normal first">First</a></li><li><a onclick="' + pagerName + '.prev();" class="pg-normal prev"> Prev</a></li> ';
         for (var page = 1; page <= this.pages; page++) 
            pagerHtml += '<li><a id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</a></li> ';
        pagerHtml += '<li><a class="pg-normal nxt" onclick="'+pagerName+'.next();" > Next </a"></li><li><a onclick="' + pagerName + '.last();" class="pg-normal last">Last</a></li>';            
        
        element.innerHTML = pagerHtml;
    }
    
    this.showPageNav_ = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
    	
    	var pagerHtml = '<span id="pg" class="pg-normal"> &#171 First</span><span onclick="' + pagerName + '.prev();" class="pg-normal"> &#171 Prev </span> | ';
        for (var page = 1; page <= this.pages; page++) 
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> | ';
        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next &#187;</span><span id="pg" class="pg-normal last>Last</span>&nbsp;&nbsp;'+
        			'<select style="width:55px;height:25px;font-size:10px;"><option>All</option><option>10</option><option>15</option><option>20</option><option>30</option></select>';            
        
        element.innerHTML = pagerHtml;
    }
}

