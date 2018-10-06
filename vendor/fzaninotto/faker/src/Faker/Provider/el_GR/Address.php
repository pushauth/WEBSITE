<?php

namespace Faker\Provider\el_GR;

class Address extends \Faker\Provider\Address
{
    protected static $buildingNumber = ['###', '##', '#', '###-###', '##-##', '#-#'];
    protected static $streetPrefix = [
        'Όδος', 'Λεωφόρος',
    ];
    protected static $postcode = ['#####', '### ##'];
    protected static $prefecture = [
        'Άβδηρα', 'Αγαθονήσι', 'Αγιά', 'Άβδηρα', 'Αγαθονήσι', 'Αγιά', 'Αγία Βαρβάρα', 'Αγία Παρασκευή', 'Άγιοι Ανάργυροι-Καματερό', 'Άγιος Βασίλειος', 'Άγιος Δημήτριος', 'Άγιος Ευστράτιος', 'Άγιος Νικόλαος', 'Αγκίστρι', 'Άγραφα', 'Αγρίνιο', 'Αθήνα', 'Αιγάλεω', 'Αιγιάλεια', 'Αίγινα', 'Άκτιο-Βόνιτσα', 'Αλεξάνδρεια', 'Αλεξανδρούπολη', 'Αλίαρτος', 'Άλιμος', 'Αλμυρός', 'Αλμωπία', 'Αλόννησος', 'Αμάρι', 'Αμοργός', 'Αμπελόκηποι-Μενεμένη', 'Αμύνταιο', 'Αμφίκλεια-Ελάτεια', 'Αμφιλοχία', 'Αμφίπολη', 'Ανατολική Μάνη', 'Ανάφη', 'Ανδρίτσαινα-Κρέστενα', 'Άνδρος', 'Αντίπαρος', 'Ανώγεια', 'Αποκορώνας', 'Αργιθέα', 'Άργος-Μυκήνες', 'Αριστοτέλης', 'Αρριανά', 'Άρτα', 'Αρχαία Ολυμπία', 'Αρχαία Πέλλα', 'Αρχάνες-Αστερούσια', 'Ασπρόπυργος', 'Αστυπάλαια', 'Αχαρνές', 'Βάρη-Βούλα-Βουλιαγμένη', 'Βέλο-Βόχα', 'Βέροια', 'Βιάννος', 'Βισαλτία', 'Βοΐο', 'Βόλβη', 'Βόλος', 'Βόρεια Κυνουρία', 'Βορεία Τζουμέρκα', 'Βριλήσσια', 'Βύρωνας', 'Γαλάτσι', 'Γαύδος', 'Γεώργιος Καραϊσκάκης', 'Γλυφάδα', 'Γόρτυνα', 'Γορτυνία', 'Γρεβενά', 'Δάφνη-Υμηττός', 'Δέλτα', 'Δελφοί', 'Δεσκάτη', 'Διδυμότειχο', 'Δίον-Ολύμπος', 'Διόνυσος', 'Δίρφυς-Μεσσαπία', 'Δίστομο-Αράχοβα-Αντικύρα', 'Δομοκός', 'Δοξάτο', 'Δράμα', 'Δυτική Αχαΐα', 'Δυτική Μάνη', 'Δυτική Οιχαλία', 'Δυτική Πύλος-Νέστορας', 'Δωδώνη', 'Δωρίδα', 'Έδεσσα', 'Ελασσόνα', 'Ελαφόνησος', 'Ελευσίνα', 'Ελληνικό-Αργυρούπολη', 'Εμμανουήλ Παππάς', 'Εορδαία', 'Επίδαυρος', 'Ερέτρια', 'Ερμιονίδα', 'Ερύμανθος', 'Ευρώτας', 'Ζαγορά-Μουρέσι', 'Ζαγόρι', 'Ζάκυνθος', 'Ζαχάρω', 'Ζηρός', 'Ζίτσα', 'Ζωγράφου', 'Ηγουμενίτσα', 'Ηλίδα', 'Ηλιούπολη', 'Ηράκλεια', 'Ηράκλειο', 'Ηράκλειο', 'Θάσος', 'Θερμαϊκός', 'Θέρμη', 'Θέρμο', 'Θεσσαλονίκη', 'Θήβα', 'Θήρα', 'Ίασμος', 'Ιεράπετρα', 'Ιθάκη', 'Ικαριά', 'Ίλιο', 'Ίος', 'Ιστιαία-Αιδηψός', 'Ιωάννινα', 'Καβάλα', 'Καισαριανή', 'Καλάβρυτα', 'Καλαμαριά', 'Καλαμάτα', 'Καλαμπάκα', 'Καλλιθέα', 'Καλλικράτεια-Μουδανιά', 'Κάλυμνος', 'Κάνδανος-Σέλινο', 'Καρδίτσα', 'Κάρπαθος', 'Καρπενήσι', 'Κάρυστος', 'Κάσος', 'Κασσάνδρα', 'Καστοριά', 'Κατερίνη', 'Κέα', 'Κεντρικά Τζουμέρκα', 'Κερατσίνι-Δραπετσώνα', 'Κέρκυρα', 'Κεφαλονιά', 'Κηφισιά', 'Κιλελέρ', 'Κιλκίς', 'Κίμωλος', 'Κίσσαμος', 'Κοζάνη', 'Κομοτηνή', 'Κόνιτσα', 'Κορδελιό-Εύοσμος', 'Κόρινθος', 'Κορυδαλλός', 'Κύθηρα', 'Κύθνος', 'Κυλλήνη', 'Κύμη-Αλιβέρι', 'Κωρωπί', 'Κως', 'Λαγκαδάς', 'Λαμία', 'Λάρισα', 'Λαύριο', 'Λειψοί', 'Λέρος', 'Λέσβος', 'Λευκάδα', 'Λήμνος', 'Λιβαδειά', 'Λίμνη Πλαστήρα', 'Λοκροί', 'Λουτράκι-Άγιoι Θεόδωροι', 'Λυκόβρυση-Πεύκη', 'Μακρακώμη', 'Μαλεβίζι', 'Μάνδρα-Ειδυλλία', 'Μαντούδι-Λίμνη', 'Μαραθώνα', 'Μαρκόπουλο Μεσογαίας', 'Μαρούσι', 'Μαρώνεια-Σάπες', 'Μεγαλόπολη', 'Μεγανήσι', 'Μέγαρα', 'Μεγίστη', 'Μεσολόγγι', 'Μεσσήνη', 'Μεταμόρφωση', 'Μέτσοβο', 'Μήλος', 'Μινώα Πεδιάδα', 'Μονεμβασιά', 'Μοσχάτο-Ταύρος', 'Μουζάκι', 'Μύκη', 'Μύκονος', 'Μυλοπόταμος', 'Μώλος-Άγιος Κωνσταντίνος', 'Νάξος και Μικρές Κυκλάδες', 'Νάουσα', 'Ναυπακτία', 'Ναύπλιο', 'Νέα Ζίχνη', 'Νέα Ιωνία', 'Νεάπολη-Συκιές', 'Νέα Σμύρνης', 'Νεμέα', 'Νεστόριο', 'Νέστος', 'Νευροκόπι', 'Νίκαια-Άγιος Ιωάννης Ρέντης', 'Νικόλαος Σκουφάς', 'Νίσυρος', 'Νότια Κυνουρία', 'Νοτιό Πήλιο', 'Ξάνθη', 'Ξηρόμερο', 'Ξυλόκαστρο-Ευρωστίνα', 'Οινούσσες', 'Ορεστιάδα', 'Ορεστίδα', 'Οροπέδιο Λασιθίου', 'Ορχομενός', 'Παγγαίο', 'Παιανία', 'Παιονία', 'Παλαιό Φάληρο', 'Παλαμάς', 'Παλλήνη', 'Παξοί', 'Παπάγος-Χολαργός', 'Παρανέστι', 'Πάργα', 'Πάρος', 'Πάτμος', 'Πάτρα', 'Παύλος Μελάς', 'Πειραιάς', 'Πεντέλη', 'Πέραμα', 'Περιστέρι', 'Πετρούπολη', 'Πηνειός', 'Πλατανιάς', 'Πολύγυρος', 'Πόρος', 'Πρέβεζα', 'Πρέσπες', 'Προσοτσάνη', 'Πύδνα-Κολινδρός', 'Πυλαία-Χορτιάτης', 'Πύλη', 'Πύργος', 'Πωγώνι', 'Ραφήνα-Πικέρμι', 'Ρέθυμνο', 'Ρήγας Φεραίος', 'Ρόδος', 'Σαλαμίνα', 'Σαμoθράκη', 'Σάμος', 'Σαρωνικός', 'Σέρβια-Βελβεντός', 'Σέριφος', 'Σέρρες', 'Σητεία', 'Σιθωνία', 'Σίκινος', 'Σικυώνα', 'Σιντική', 'Σίφνος', 'Σκιάθος', 'Σκόπελος', 'Σκύδρα', 'Σκύρος', 'Σούλι', 'Σουφλί', 'Σοφάδες', 'Σπάρτη', 'Σπάτα-Άρτεμη', 'Σπέτσες', 'Στυλίδα', 'Σύμη', 'Σύρος-Ερμούπολη', 'Σφακιά', 'Τανάγρα', 'Τέμπη', 'Τήλος', 'Τήνος', 'Τόπειρος', 'Τρίκαλα', 'Τρίπολη', 'Τριφυλλία', 'Τροιζηνία', 'Τύρναβος', 'Ύδρα', 'Φαιστός', 'Φαρκαδόνας', 'Φάρσαλα', 'Φιλαδέλφεια-Χαλκηδόνα', 'Φιλιάτες', 'Φιλοθέη-Ψυχικό', 'Φλώρινα', 'Φολέγανδρος', 'Φούρνοι', 'Φυλή', 'Χαϊδάρι', 'Χαλάνδρι', 'Χαλκηδόνα', 'Χάλκη', 'Χαλκίδα', 'Χανιά', 'Χερσόνησος', 'Χίος', 'Ψαρά', 'Ωραιόκαστρο', 'Ωρωπός Βαρβάρα', 'Αγία', 'Παρασκευή', 'Άγιοι', 'Ανάργυροι-Καματερό', 'Άγιος', 'Βασίλειος', 'Άγιος', 'Δημήτριος', 'Άγιος', 'Ευστράτιος', 'Άγιος', 'Νικόλαος', 'Αγκίστρι', 'Άγραφα', 'Αγρίνιο', 'Αθήνα', 'Αιγάλεω', 'Αιγιάλεια', 'Αίγινα', 'Άκτιο-Βόνιτσα', 'Αλεξάνδρεια', 'Αλεξανδρούπολη', 'Αλίαρτος', 'Άλιμος', 'Αλμυρός', 'Αλμωπία', 'Αλόννησος', 'Αμάρι', 'Αμοργός', 'Αμπελόκηποι-Μενεμένη', 'Αμύνταιο', 'Αμφίκλεια-Ελάτεια', 'Αμφιλοχία', 'Αμφίπολη', 'Ανατολική', 'Μάνη', 'Ανάφη', 'Ανδρίτσαινα-Κρέστενα', 'Άνδρος', 'Αντίπαρος', 'Ανώγεια', 'Αποκορώνας', 'Αργιθέα', 'Άργος-Μυκήνες', 'Αριστοτέλης', 'Αρριανά', 'Άρτα', 'Αρχαία', 'Ολυμπία', 'Αρχαία', 'Πέλλα', 'Αρχάνες-Αστερούσια', 'Ασπρόπυργος', 'Αστυπάλαια', 'Αχαρνές', 'Βάρη-Βούλα-Βουλιαγμένη', 'Βέλο-Βόχα', 'Βέροια', 'Βιάννος', 'Βισαλτία', 'Βοΐο', 'Βόλβη', 'Βόλος', 'Βόρεια', 'Κυνουρία', 'Βορεία', 'Τζουμέρκα', 'Βριλήσσια', 'Βύρωνας', 'Γαλάτσι', 'Γαύδος', 'Γεώργιος', 'Καραϊσκάκης', 'Γλυφάδα', 'Γόρτυνα', 'Γορτυνία', 'Γρεβενά', 'Δάφνη-Υμηττός', 'Δέλτα', 'Δελφοί', 'Δεσκάτη', 'Διδυμότειχο', 'Δίον-Ολύμπος', 'Διόνυσος', 'Δίρφυς-Μεσσαπία', 'Δίστομο-Αράχοβα-Αντικύρα', 'Δομοκός', 'Δοξάτο', 'Δράμα', 'Δυτική', 'Αχαΐα', 'Δυτική', 'Μάνη', 'Δυτική', 'Οιχαλία', 'Δυτική', 'Πύλος-Νέστορας', 'Δωδώνη', 'Δωρίδα', 'Έδεσσα', 'Ελασσόνα', 'Ελαφόνησος', 'Ελευσίνα', 'Ελληνικό-Αργυρούπολη', 'Εμμανουήλ', 'Παππάς', 'Εορδαία', 'Επίδαυρος', 'Ερέτρια', 'Ερμιονίδα', 'Ερύμανθος', 'Ευρώτας', 'Ζαγορά-Μουρέσι', 'Ζαγόρι', 'Ζάκυνθος', 'Ζαχάρω', 'Ζηρός', 'Ζίτσα', 'Ζωγράφου', 'Ηγουμενίτσα', 'Ηλίδα', 'Ηλιούπολη', 'Ηράκλεια', 'Ηράκλειο', 'Ηράκλειο', 'Θάσος', 'Θερμαϊκός', 'Θέρμη', 'Θέρμο', 'Θεσσαλονίκη', 'Θήβα', 'Θήρα', 'Ίασμος', 'Ιεράπετρα', 'Ιθάκη', 'Ικαριά', 'Ίλιο', 'Ίος', 'Ιστιαία-Αιδηψός', 'Ιωάννινα', 'Καβάλα', 'Καισαριανή', 'Καλάβρυτα', 'Καλαμαριά', 'Καλαμάτα', 'Καλαμπάκα', 'Καλλιθέα', 'Καλλικράτεια-Μουδανιά', 'Κάλυμνος', 'Κάνδανος-Σέλινο', 'Καρδίτσα', 'Κάρπαθος', 'Καρπενήσι', 'Κάρυστος', 'Κάσος', 'Κασσάνδρα', 'Καστοριά', 'Κατερίνη', 'Κέα', 'Κεντρικά', 'Τζουμέρκα', 'Κερατσίνι-Δραπετσώνα', 'Κέρκυρα', 'Κεφαλονιά', 'Κηφισιά', 'Κιλελέρ', 'Κιλκίς', 'Κίμωλος', 'Κίσσαμος', 'Κοζάνη', 'Κομοτηνή', 'Κόνιτσα', 'Κορδελιό-Εύοσμος', 'Κόρινθος', 'Κορυδαλλός', 'Κύθηρα', 'Κύθνος', 'Κυλλήνη', 'Κύμη-Αλιβέρι', 'Κωρωπί', 'Κως', 'Λαγκαδάς', 'Λαμία', 'Λάρισα', 'Λαύριο', 'Λειψοί', 'Λέρος', 'Λέσβος', 'Λευκάδα', 'Λήμνος', 'Λιβαδειά', 'Λίμνη', 'Πλαστήρα', 'Λοκροί', 'Λουτράκι-Άγιoι', 'Θεόδωροι', 'Λυκόβρυση-Πεύκη', 'Μακρακώμη', 'Μαλεβίζι', 'Μάνδρα-Ειδυλλία', 'Μαντούδι-Λίμνη', 'Μαραθώνα', 'Μαρκόπουλο', 'Μεσογαίας', 'Μαρούσι', 'Μαρώνεια-Σάπες', 'Μεγαλόπολη', 'Μεγανήσι', 'Μέγαρα', 'Μεγίστη', 'Μεσολόγγι', 'Μεσσήνη', 'Μεταμόρφωση', 'Μέτσοβο', 'Μήλος', 'Μινώα', 'Πεδιάδα', 'Μονεμβασιά', 'Μοσχάτο-Ταύρος', 'Μουζάκι', 'Μύκη', 'Μύκονος', 'Μυλοπόταμος', 'Μώλος-Άγιος', 'Κωνσταντίνος', 'Νάξος', 'και', 'Μικρές', 'Κυκλάδες', 'Νάουσα', 'Ναυπακτία', 'Ναύπλιο', 'Νέα', 'Ζίχνη', 'Νέα', 'Ιωνία', 'Νεάπολη-Συκιές', 'Νέα', 'Σμύρνης', 'Νεμέα', 'Νεστόριο', 'Νέστος', 'Νευροκόπι', 'Νίκαια-Άγιος', 'Ιωάννης', 'Ρέντης', 'Νικόλαος', 'Σκουφάς', 'Νίσυρος', 'Νότια', 'Κυνουρία', 'Νοτιό', 'Πήλιο', 'Ξάνθη', 'Ξηρόμερο', 'Ξυλόκαστρο-Ευρωστίνα', 'Οινούσσες', 'Ορεστιάδα', 'Ορεστίδα', 'Οροπέδιο', 'Λασιθίου', 'Ορχομενός', 'Παγγαίο', 'Παιανία', 'Παιονία', 'Παλαιό', 'Φάληρο', 'Παλαμάς', 'Παλλήνη', 'Παξοί', 'Παπάγος-Χολαργός', 'Παρανέστι', 'Πάργα', 'Πάρος', 'Πάτμος', 'Πάτρα', 'Παύλος', 'Μελάς', 'Πειραιάς', 'Πεντέλη', 'Πέραμα', 'Περιστέρι', 'Πετρούπολη', 'Πηνειός', 'Πλατανιάς', 'Πολύγυρος', 'Πόρος', 'Πρέβεζα', 'Πρέσπες', 'Προσοτσάνη', 'Πύδνα-Κολινδρός', 'Πυλαία-Χορτιάτης', 'Πύλη', 'Πύργος', 'Πωγώνι', 'Ραφήνα-Πικέρμι', 'Ρέθυμνο', 'Ρήγας', 'Φεραίος', 'Ρόδος', 'Σαλαμίνα', 'Σαμoθράκη', 'Σάμος', 'Σαρωνικός', 'Σέρβια-Βελβεντός', 'Σέριφος', 'Σέρρες', 'Σητεία', 'Σιθωνία', 'Σίκινος', 'Σικυώνα', 'Σιντική', 'Σίφνος', 'Σκιάθος', 'Σκόπελος', 'Σκύδρα', 'Σκύρος', 'Σούλι', 'Σουφλί', 'Σοφάδες', 'Σπάρτη', 'Σπάτα-Άρτεμη', 'Σπέτσες', 'Στυλίδα', 'Σύμη', 'Σύρος-Ερμούπολη', 'Σφακιά', 'Τανάγρα', 'Τέμπη', 'Τήλος', 'Τήνος', 'Τόπειρος', 'Τρίκαλα', 'Τρίπολη', 'Τριφυλλία', 'Τροιζηνία', 'Τύρναβος', 'Ύδρα', 'Φαιστός', 'Φαρκαδόνας', 'Φάρσαλα', 'Φιλαδέλφεια-Χαλκηδόνα', 'Φιλιάτες', 'Φιλοθέη-Ψυχικό', 'Φλώρινα', 'Φολέγανδρος', 'Φούρνοι', 'Φυλή', 'Χαϊδάρι', 'Χαλάνδρι', 'Χαλκηδόνα', 'Χάλκη', 'Χαλκίδα', 'Χανιά', 'Χερσόνησος', 'Χίος', 'Ψαρά', 'Ωραιόκαστρο', 'Ωρωπός'];
    protected static $country = [
        'Ανγκόλα', 'Αζερμπαϊτζάν', 'Αίγυπτος', 'Αιθιοπία', 'Αϊτή', 'Αλβανία', 'Αλγερία', 'Αργεντινή', 'Αρμενία', 'Αυστραλία', 'Αυστρία', 'Αφγανιστάν',
        'Βέλγιο', 'Βενεζουέλα', 'Βιετνάμ', 'Βολιβία', 'Βοσνία και Ερζεγοβίνη', 'Βουλγαρία', 'Βραζιλία',
        'Γαλλία', 'Γερμανία', 'Γεωργία', 'Γροιλανδία',
        'Δανία', 'Δομινικανή Δημοκρατία',
        'Ελβετία', 'Ελλάδα', 'Ερυθραία', 'Εσθονία',
        'ΗΠΑ', 'Ηνωμένο Βασίλειο',
        'Ιαπωνία', 'Ινδία', 'Ινδονησία', 'Ιορδανία', 'Ιράκ', 'Ιράν', 'Ιρλανδία', 'Ισλανδία', 'Ισπανία', 'Ισραήλ', 'Ιταλία',
        'Καζακστάν', 'Καμπότζη', 'Καναδάς', 'Κεντροαφρικανική Δημοκρατία', 'Κένυα', 'Κίνα', 'Κιργιζία', 'Κολομβία', 'Κομόρες', 'Δημοκρατία του Κονγκό', 'Λαϊκή Δημοκρατία του Κονγκό', 'Βόρεια Κορέα', 'Νότια Κορέα', 'Κόστα Ρίκα', 'Κουβέιτ', 'Κροατία', 'Κύπρος',
        'Λάος', 'Λεττονία', 'Λευκορωσία', 'Λίβανος', 'Λιβερία', 'Λιβύη', 'Λιθουανία', 'Λουξεμβούργο',
        'Μαδαγασκάρη', 'Μαλαισία', 'Μάλτα', 'Μαρόκο', 'Μαυρίκιος', 'Μαυριτανία', 'Μαυροβούνιο', 'Μεξικό', 'Μογγολία', 'Μοζαμβίκη', 'Μολδαβία', 'Μονακό', 'Μποτσουάνα', 'Μπουρούντι', 'Μπουτάν',
        'Νέα Ζηλανδία', 'Νεπάλ', 'Νίγηρας', 'Νιγηρία', 'Νικαράγουα', 'Νορβηγία', 'Νότια Αφρική',
        'Ολλανδία', 'Ουγγαρία', 'Ουγκάντα', 'Ουζμπεκιστάν', 'Ουκρανία', 'Ουρουγουάη',
        'Πακιστάν', 'Παλαιστίνη', 'Παναμάς', 'Παραγουάη', 'Περού', 'Πολωνία', 'Πουέρτο Ρίκο', 'Πορτογαλία', 'Πρώην Γιουγκοσλαβική Δημοκρατία της Μακεδονίας',
        'Ρουάντα', 'Ρουμανία', 'Ρωσία',
        'Σαμόα', 'Σαουδική Αραβία', 'Σενεγάλη', 'Σερβία', 'Σιγκαπούρη', 'Σλοβακία', 'Σλοβενία', 'Σομαλία', 'Σουαζιλάνδη', 'Σουδάν', 'Σουηδία', 'Σουρινάμ', 'Συρία',
        'Ταϊβάν', 'Ταϊλάνδη', 'Τανζανία', 'Τατζικιστάν', 'Τζαμάικα', 'Τόγκο', 'Τόνγκα', 'Τουβαλού', 'Τουρκία', 'Τουρκμενιστάν', 'Τσεχία', 'Τυνησία',
        'Υεμένη',
        'Φιλιππίνες', 'Φινλανδία',
        'Χιλή',
    ];
    protected static $streetNameFormats = [
        '{{streetPrefix}} {{lastNameMale}}',
        '{{streetPrefix}} {{lastNameFemale}}',
    ];
    protected static $streetAddressFormats = [
        '{{streetName}}, {{buildingNumber}}',
    ];
    protected static $addressFormats = [
        "{{streetAddress}}, {{postcode}}, {{prefecture}}",
    ];

    /**
     * @example 'Όδος'
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * @example 'Θερμαϊκός'
     */
    public static function prefecture()
    {
        return static::randomElement(static::$prefecture);
    }
}
