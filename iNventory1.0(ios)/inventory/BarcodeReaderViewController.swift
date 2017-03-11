//
//  BarcodeReaderViewController.swift
//  RSBarcodesSample
//
//  Created by R0CKSTAR on 6/10/14.
//
//  Updated by Jarvie8176 on 01/21/2016
//
//  Copyright (c) 2014 P.D.Q. All rights reserved.
//

import UIKit
import AVFoundation
import RSBarcodes

protocol BarcodeScan {
    func setBarcodeScanResult(which: String, result: String)
}

class BarcodeReaderViewController: RSCodeReaderViewController {
    
    var barcodescanresult: BarcodeScan?
    
    @IBAction func onBack(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    @IBAction func switchCamera(_ sender: Any) {
        let position = self.switchCamera()
        
        if position == AVCaptureDevicePosition.back {
            print("back camera.")
        } else {
            print("front camera.")
        }
    }
    @IBAction func toggle(_ sender: Any) {
        let isTorchOn = self.toggleTorch()
        print(isTorchOn)
    }
    @IBOutlet var toggle: UIButton!
    var whichnumber: String!
    var barcode: String = ""
    var dispatched: Bool = false
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // MARK: NOTE: Uncomment the following line to enable crazy mode
        // self.isCrazyMode = true
        
        self.focusMarkLayer.strokeColor = UIColor.red.cgColor
        
        self.cornersLayer.strokeColor = UIColor.yellow.cgColor
        
        self.tapHandler = { point in
            print(point)
        }
        
        // MARK: NOTE: If you want to detect specific barcode types, you should update the types
        let types = NSMutableArray(array: self.output.availableMetadataObjectTypes)
        // MARK: NOTE: Uncomment the following line remove QRCode scanning capability
        // types.removeObject(AVMetadataObjectTypeQRCode)
        self.output.metadataObjectTypes = NSArray(array: types) as [AnyObject]
        
        // MARK: NOTE: If you layout views in storyboard, you should these 3 lines
        for subview in self.view.subviews {
            self.view.bringSubview(toFront: subview)
        }
        
        self.toggle.isEnabled = self.hasTorch()
        
        self.barcodesHandler = { barcodes in
            if !self.dispatched { // triggers for only once
                self.dispatched = true
                for barcode in barcodes {
                    self.barcode = barcode.stringValue
                    print("Barcode found: type=" + barcode.type + " value=" + barcode.stringValue)
                    
                    DispatchQueue.main.async(execute: {
                        //self.performSegue(withIdentifier: "addinventoryview", sender: self)
                        
                        if self.whichnumber == "serialnumber" {
                            self.barcodescanresult?.setBarcodeScanResult(which: "serialnumber", result: self.barcode)
                        }
                        else {
                            self.barcodescanresult?.setBarcodeScanResult(which: "partnumber", result: self.barcode)
                        }
                        self.navigationController?.popViewController(animated: true)
                        
                        
                        // MARK: NOTE: Perform UI related actions here.
                    })
                    
                    // MARK: NOTE: break here to only handle the first barcode object
                    break
                }
            }
        }
    }
    
    override func viewWillAppear(_ animated: Bool) {
        self.dispatched = false // reset the flag so user can do another scan
        
        super.viewWillAppear(animated)
        
        if let navigationController = self.navigationController {
            navigationController.isNavigationBarHidden = true
        }
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if let navigationController = self.navigationController {
            navigationController.isNavigationBarHidden = false
        }
        
//        if segue.identifier == "addinventoryview" && !self.barcode.isEmpty {
//            
//            if let destinationVC = segue.destination as? AddInventoryViewController {
//                if whichnumber == "serialnumber" {
//                    destinationVC.serialnumber = self.barcode
//                }
//                else if whichnumber == "partnumber" {
//                    destinationVC.partnumber = self.barcode
//                }
//            }
//        }
    }
}
