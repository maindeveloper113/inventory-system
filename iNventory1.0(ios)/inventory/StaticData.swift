//
//  StaticData.swift
//  inventory
//
//  Created by admin on 1/20/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit
import SystemConfiguration

class StaticData {
    
    public static let ip_key = "ip";
    public static let port_key = "port";
    
    public static let sublink = "/inventory/Services/";
    
    public static func getlink() -> String {
        let userdefaults = UserDefaults.standard
        
        let ip = userdefaults.string(forKey: StaticData.ip_key) ?? "rescuestartup.com"
        let port = userdefaults.string(forKey: StaticData.port_key) ?? ""
        
        var link: String!
        
        if port == "" {
            if port == "80" {
				link = "http://www." + ip + sublink
            }
            else {
    
				link = "http://www." + ip + sublink
            }
        }
        else {
            if port == "80" {
				link = "http://www." + ip + sublink
            }
            else {
				link = "http://www." + ip + ":" + port + sublink
            }
        }
    
        //link = "http://www.rescuestartup.com/inventory/Services/";
        //link = "http://198.18.52.11/inventory/Services/";
        
        return link!;
    }
    
    public static func setDefalut() {
        let userdefaults = UserDefaults.standard
        
        let ip = userdefaults.string(forKey: StaticData.ip_key) ?? "rescuestartup.com"
        if ip == "" {
            userdefaults.set("rescuestartup.com", forKey: StaticData.ip_key)
            
        }
        
        
        
                
    }
    
    public func isNetworkConnected() -> Bool
    {
        
        var zeroAddress = sockaddr_in()
        zeroAddress.sin_len = UInt8(MemoryLayout.size(ofValue: zeroAddress))
        zeroAddress.sin_family = sa_family_t(AF_INET)
        
        let defaultRouteReachability = withUnsafePointer(to: &zeroAddress) {
            $0.withMemoryRebound(to: sockaddr.self, capacity: 1) {zeroSockAddress in
                SCNetworkReachabilityCreateWithAddress(nil, zeroSockAddress)
            }
        }
        
        var flags = SCNetworkReachabilityFlags()
        if !SCNetworkReachabilityGetFlags(defaultRouteReachability!, &flags) {
            return false
        }
        let isReachable = (flags.rawValue & UInt32(kSCNetworkFlagsReachable)) != 0
        let needsConnection = (flags.rawValue & UInt32(kSCNetworkFlagsConnectionRequired)) != 0
        return (isReachable && !needsConnection)
        
    }


}
