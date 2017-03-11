//
//  ConfirmViewController.swift
//  inventory
//
//  Created by admin on 1/20/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class ConfirmViewController: UIViewController {

    @IBOutlet var et_ip: UITextField!
    @IBOutlet var et_port: UITextField!
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        
       
        setPrevious()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func save(_ sender: Any) {
        
        confirmServer()
        
        let alert = UIAlertController(title: "Success", message: "Success cofirm IP and port!", preferredStyle: UIAlertControllerStyle.alert)
        let action = UIAlertAction(title: "OK", style: UIAlertActionStyle.default) { (action) -> Void in
            //let viewControllerYouWantToPresent = self.storyboard?.instantiateViewController(withIdentifier: "loginview")
            //self.present(viewControllerYouWantToPresent!, animated: true, completion: nil)
            self.navigationController?.popViewController(animated: true)
            
        }
        alert.addAction(action)
        self.present(alert, animated: true, completion: nil)

    }

   
    
    public func setPrevious() {
        
        let userdefaults = UserDefaults.standard
    
        let ip = userdefaults.string(forKey: StaticData.ip_key) ?? "rescuestartup.com"
        et_ip.text =  ip
        
        let port = userdefaults.string(forKey: StaticData.port_key) ?? ""
        et_port.text =  port
        
    }
    
    private func confirmServer() {
    
        let userdefaluts = UserDefaults.standard
    
        if et_port.text != "" {
            userdefaluts.set(et_port.text, forKey: StaticData.port_key)
        }
        else {
            userdefaluts.set("", forKey: StaticData.port_key)
        }
        
        if et_ip.text != "" {
            userdefaluts.set(et_ip.text, forKey: StaticData.ip_key)
        }
        else {
            userdefaluts.set("", forKey: StaticData.ip_key)
        }
    }

}
