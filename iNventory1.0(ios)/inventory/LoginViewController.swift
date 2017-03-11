//
//  ViewController.swift
//  inventory
//
//  Created by admin on 1/20/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class LoginViewController: UIViewController {

    @IBOutlet var et_pass: UITextField!
    @IBOutlet var et_email: UITextField!
    
    var email: String?, pass: String?
    var Response_code: String?
    @IBOutlet var background: UIImageView!
    @IBOutlet var activityindicatorcontainer: UIView!
    
    var login_error_message: String?, result: String?
    let session = SessionManager()
    var user_id: String?
    var user = [String: String]()
    var jobj: JSONSerialization?
    var login_error: Bool?
    

    
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
       
        StaticData.setDefalut()
        setContent()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func setContent() {
      
            
        user = session.getUserDetails()
        
        email = user[session.KEY_EMAIL]
        et_email.text = email
        activityindicatorcontainer.isHidden = true
       
//        activityIndicator.hidesWhenStopped = true
//        activityIndicator.stopAnimating()
        
        
        
    }
    
    


    @IBAction func login(_ sender: Any) {
        
        et_pass.resignFirstResponder()
        et_email.resignFirstResponder()
        
        if (et_email.text == "") {
            let alert = UIAlertController(title: "Warnning", message: "Please enter a email", preferredStyle: UIAlertControllerStyle.alert)
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler: nil))
            self.present(alert, animated: true, completion: nil)
        }
        else if et_pass.text == "" {
            let alert = UIAlertController(title: "Warnning", message: "Please enter a password", preferredStyle: UIAlertControllerStyle.alert)
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler: nil))
            self.present(alert, animated: true, completion: nil)
        
        }
        else {
            email = et_email.text
            pass = et_pass.text
            
            let json = ["email":email, "password":pass]
            
            activityindicatorcontainer.isHidden = false
            showActivityIndicatory(uiView: activityindicatorcontainer)
            
            do {
                let jsonData = try JSONSerialization.data(withJSONObject: json, options: .prettyPrinted)
                
                let url = StaticData.getlink() + "login.php"
            
                var request = URLRequest(url: URL(string: url)!)
            
                request.httpMethod = "POST"
                request.httpBody = jsonData
                //request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
                
                
                let task = URLSession.shared.dataTask(with: request) { (data: Data?, response: URLResponse?, error: Error?) in
                    
                    if error != nil
                    {
                        print("error=\(error)")
                        return
                    }
                    
                    // You can print out response object
                    print("response = \(response)")
                    
                    //Let's convert response sent from a server side script to a NSDictionary object:
                    do {
                        
                        let json = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSDictionary
                       
                        if let parseJSON = json {
                            
                            // Now we can access value of First Name by its key
                            self.login_error = parseJSON["error"] as? Bool
                            self.login_error_message = parseJSON["error_msg"] as? String
                            self.user_id = parseJSON["user_id"] as? String
                            
                            print("respone error = \(self.login_error)")
                            
                        
                            
                        }
 
                    } catch {
                        print("error")
                    }
                    
                    self.LoginCheck()
                    
                    
                }
                task.resume()
                

            } catch {
                print("error")
            }
            
            
            
        }
        
    }
    
    private func LoginCheck() {
        
        DispatchQueue.main.async { [unowned self] in
            
//            self.activityIndicator.stopAnimating()
            
            self.activityindicatorcontainer.isHidden = true
        
            if self.login_error! {
            
                let alert = UIAlertController(title: "Warnning", message: self.login_error_message, preferredStyle: UIAlertControllerStyle.alert)
                alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler:{(ACTION) in
                    self.activityindicatorcontainer.isHidden = true
                }))
                self.present(alert, animated: true, completion: nil)
            
            }
            else {
            
                let session = SessionManager()
                session.createLoginSession(user_id: self.user_id!);
                session.registerUser(email: self.email!, pass: self.pass!);
                
                self.et_pass.text = ""
                self.et_email.text = ""
                
                let storyBoard : UIStoryboard = UIStoryboard(name: "Main", bundle:nil)
                let nextViewController = storyBoard.instantiateViewController(withIdentifier: "homeview") as! HomeViewController
                
                self.navigationController?.pushViewController(nextViewController, animated: true)
                
        

            
            }
        }

    }
    
    func showActivityIndicatory(uiView: UIView) {
        
        let loadingView: UIView = UIView()
        loadingView.frame = CGRect.init(x: 0, y: 0, width: 80, height: 80)
        loadingView.center = uiView.center
        loadingView.backgroundColor = UIColor.lightGray.withAlphaComponent(0.7)
        loadingView.clipsToBounds = true
        loadingView.layer.cornerRadius = 10
        
        let actInd: UIActivityIndicatorView = UIActivityIndicatorView()
        actInd.frame = CGRect.init(x:0.0, y:0.0, width:40.0, height:40.0);
        actInd.activityIndicatorViewStyle =
            UIActivityIndicatorViewStyle.whiteLarge
        actInd.center = CGPoint.init(x: loadingView.frame.size.width / 2,
            y:loadingView.frame.size.height / 2);
        loadingView.addSubview(actInd)
        uiView.addSubview(loadingView)
        
        actInd.startAnimating()
    }
    
    
}

