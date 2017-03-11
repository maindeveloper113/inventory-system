//
//  HomeViewController.swift
//  inventory
//
//  Created by admin on 1/20/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class HomeViewController: UIViewController {

 
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

   

//    // In a storyboard-based application, you will often want to do a little preparation before navigation
//    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
//        // Get the new view controller using segue.destinationViewController.
//        // Pass the selected object to the new view controller.
//        
//        if segue.identifier == "" {
//            if let destinationVC = segue.destination as? BarcodeReaderViewController {
//                destinationVC.whichnumber = "partnumber"
//            }
//        }
//        
//        
//    }
    

    @IBAction func add_inventory(_ sender: Any) {
    }
    
    
    @IBAction func view_inventory(_ sender: Any) {
    }
    
    @IBAction func logout(_ sender: Any) {
        let alert = UIAlertController(title: "Logout", message: "Are you sure you want to log out?", preferredStyle: UIAlertControllerStyle.alert)
        let yes = UIAlertAction(title: "Yes", style: UIAlertActionStyle.default, handler: {(ACTION) in
            let session = SessionManager()
            session.logoutUser()
            
            
            self.navigationController?.popViewController(animated: true)
        })
        let no = UIAlertAction(title: "No", style: UIAlertActionStyle.default, handler: nil)
        alert.addAction(yes)
        alert.addAction(no)
        self.present(alert, animated: true, completion: nil)
    }
}
