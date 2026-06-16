const fs = require('fs');
const path = 'c:/Users/Aditya/Documents/Projeks/toko-sembako/resources/views/customer/home.blade.php';
let content = fs.readFileSync(path, 'utf8');

// Replace $cat['desc'] with $cat['description']
content = content.replace(/\$cat\['desc'\]/g, "$cat['description']");

// Replace "item" (singular) with "items" (plural) in the category section
content = content.replace(/{{ \$cat\['count'\] }} item(?=<\/span>)/g, "{{ $cat['count'] }} items");

fs.writeFileSync(path, content, 'utf8');
console.log('Done');
