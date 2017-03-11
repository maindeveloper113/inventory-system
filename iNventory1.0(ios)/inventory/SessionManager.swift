//
//  SessionManager.swift
//  inventory
//
//  Created by admin on 1/20/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class SessionManager {
    
    var logout_id = "0"
    
    let IS_LOGIN = "IsLoggedIn";
    
    public let KEY_EMAIL = "email";
    
    
    public let KEY_UserId = "user_id";
    public let KEY_UserPassword = "user_pass";
    var user = [String: String]()
    let userdefaults = UserDefaults.standard
    
    public func createLoginSession(user_id: String) {
        
        userdefaults.set(user_id, forKey: self.KEY_UserId)
        
    }
    
    public func registerUser(email: String, pass:String) {
        userdefaults.set(email, forKey: KEY_EMAIL)
        userdefaults.set(pass, forKey: KEY_UserPassword)
    
    }
    
    public func getUserDetails() -> [String: String] {
    
    
        // user email id
        let email = userdefaults.value(forKey: KEY_EMAIL)
        if email != nil {
            user.updateValue(email as! String, forKey: KEY_EMAIL)
        }
        else {
            user.updateValue("", forKey: KEY_EMAIL)
        }
        
        let user_id = userdefaults.value(forKey: KEY_UserId)
        if user_id != nil {
            user.updateValue(user_id as! String, forKey: KEY_UserId)
        }
        else {
            user.updateValue("", forKey: KEY_UserId)
        }
        
    
        //user.updateValue(userdefaults.value(forKey: KEY_UserPassword) as! String, forKey: KEY_UserPassword)
        
        
        // return user
        return user;
    }
    
    public func logoutUser() {
        
        registerUser(email: "", pass: "")
        logout_id = "1"
        
//        let appDelegate = UIApplication.shared.delegate! as! AppDelegate
//        
//        let initialViewController = controller.storyboard!.instantiateViewController(withIdentifier: "loginview")
//        appDelegate.window?.rootViewController = initialViewController
//        appDelegate.window?.makeKeyAndVisible()
        
    }
    
    public func isLoggnedIn() -> Bool {
        return (userdefaults.value(forKey: IS_LOGIN) != nil)
    }

}
