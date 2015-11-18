<?php
class GuestService2 {
    
    public static function listGuests() {
        $db = Connectionfactory::getDB();
        $guests = array();
        
        foreach($db->tasks() as $guest) {
           $guests[] = array (
               'id' => $guest['id'],
               'name' => $guest['name'],
               'email' => $guest['email']
           ); 
        }
        
        return $guests;
    }
    
    public static function getById($id) {
        $db = Connectionfactory::getDB();
        return $db->guests[$id];
    }
    
    public static function add($newGuest) {
        $db = Connectionfactory::getDB();
        $guest = $db->guests->insert($newGuest);
        return $guest;
    }
    
    public static function update($updatedGuest) {
        $db = Connectionfactory::getDB();
        $guest = $db->guests[$updatedGuest['id']];
        
        if($guest) {
            $guest['name'] = $updatedGuest['name'];
            $guest['email'] = $updatedGuest['email'];
             $guest->update();
            return true;
        }
        
        return false;
    }
    
    public static function delete($id) {
        $db = Connectionfactory::getDB();
        $guest = $db->guests[$id];
        if($guest) {
            $guest->delete();
            return true;
        }
        return false;
    }
}
?>

